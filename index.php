<?php

include('./db_class.php');




function random_pronounceable_word( $length = 6 ) {
       
        // consonant sounds
        $cons = array(
                // single consonants. Beware of Q, it's often awkward in words
                'b', 'c', 'd', 'f', 'g', 'h', 'j', 'k', 'l', 'm',
                'n', 'p', 'r', 's', 't', 'v', 'w', 'x', 'z',
                // possible combinations excluding those which cannot start a word
                'pt', 'gl', 'gr', 'ch', 'ph', 'ps', 'sh', 'st', 'th', 'wh',
        );
       
        // consonant combinations that cannot start a word
        $cons_cant_start = array(
                'ck', 'cm',
                'dr', 'ds',
                'ft',
                'gh', 'gn',
                'kr', 'ks',
                'ls', 'lt', 'lr',
                'mp', 'mt', 'ms',
                'ng', 'ns',
                'rd', 'rg', 'rs', 'rt',
                'ss',
                'ts', 'tch',
        );
       
        // wovels
        $vows = array(
                // single vowels
                'a', 'e', 'i', 'o', 'u', 'y',
                // vowel combinations your language allows
                'ee', 'oa', 'oo',
        );
       
        // start by vowel or consonant ?
        $current = ( mt_rand( 0, 1 ) == '0' ? 'cons' : 'vows' );
       
        $word = '';
               
        while( strlen( $word ) < $length ) {
       
                // After first letter, use all consonant combos
                if( strlen( $word ) == 2 )
                        $cons = array_merge( $cons, $cons_cant_start );
 
                 // random sign from either $cons or $vows
                $rnd = ${$current}[ mt_rand( 0, count( ${$current} ) -1 ) ];
               
                // check if random sign fits in word length
                if( strlen( $word . $rnd ) <= $length ) {
                        $word .= $rnd;
                        // alternate sounds
                        $current = ( $current == 'cons' ? 'vows' : 'cons' );
                }
        }
       
        return $word;
}



$db = new db();

if(isset($_POST['submitted'])){



  if(isset($_POST['sex'])){
    if(empty($_POST['scabies']))
      $_POST['scabies'] = 0;
    if(empty($_POST['needs_protection']))
      $_POST['needs_protection'] = 0;
    if(empty($_POST['medical_case']))
      $_POST['medical_case'] = 0;
    if(empty($_POST['nationality']))
      $_POST['nationality'] = '';
    if(empty($_POST['alone_traveling_woman']))
      $_POST['alone_traveling_woman'] = 0;
    if(empty($_POST['age']))
      $_POST['age'] = '';
    if(empty($_POST['unaccopanied_minor']))
      $_POST['unaccopanied_minor'] = 0;
    if(empty($_POST['pregnant_woman']))
      $_POST['pregnant_woman'] = 0;
    $id = $db->insert('people_on_board',
      array(
        'sex'=>$_POST['sex'],
        'scabies'=>$_POST['scabies'],
        'needs_protection'=>$_POST['needs_protection'],
        'boat_id'=>$_POST['boat'],
        'medical_case'=>$_POST['medical_case'],
        'nationality'=>$_POST['nationality'],
        'alone_traveling_woman'=>$_POST['alone_traveling_woman'],
        'age'=>$_POST['age'],
        'unaccopanied_minor'=>$_POST['unaccopanied_minor'],
        'pregnant_woman'=>$_POST['pregnant_woman'])
      );
    echo $id;
  }else{
    echo '<center>Please fill out all the fields!</center>';
  }

}else if($_GET['action'] == "addBoat"){

    $id = $db->insert('boats',array('timestamp'=>time(), 'active'=>1, 'boat_code'=>random_pronounceable_word()));

    echo $id;

}else if($_GET['action'] == "deactivateBoat"){

    $id = $db->update('boats',array('active'=>0), array('id',$_GET['id']));
    header('Location: ./#overView');
    die();

}else if($_GET['action'] == "reactivateBoat"){

    $id = $db->update('boats',array('active'=>1), array('id',$_GET['id']));
    header('Location: ./#overView');
    die();

}

?>
<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bare - Start Bootstrap Template</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <style>
      body {
        padding-top: 54px;
      }
      @media (min-width: 992px) {
        body {
          padding-top: 56px;
        }
      }

    </style>

  </head>

  <body>

    <!-- Navigation -->
   
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">SW3 Statistics</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="#addPerson" onclick="$('.overview_toggle').toggle(); $('.nav-item').toggleClass('active');">Add Person
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#overView" onclick="$('.overview_toggle').toggle(); $('.nav-item').toggleClass('active');">Overview</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Page Content -->
    <div class="container overview_toggle">
      <div class="row">
        <div class="col-lg-12">

<?php

$boats = $db->query('SELECT * FROM boats');
?>
          <form action="./" method="post">
            <fieldset class="form-group">
              <legend><a href="?action=addBoat">+</a>Boat</legend>
              <div class="form-check">
                <label class="form-check-label">
                <?php
                echo '<select name="boat">';
                foreach($boats AS $boat){
                  echo '<option value="'.$boat['id'].'">'.date('d.m. H:i', $boat['timestamp']).' - '.$boat['boat_code'].'</option>';
                }
                echo '</select>';
                ?>
                </label>
              </div>
            </fieldset>
            <fieldset class="form-group">
              <legend>Please Choose</legend>
              <div class="form-check">
                <label class="form-check-label">
                  <input type="radio" value="m" class="form-check-input" name="sex" id="optionsRadios1" checked>
                  Male
                </label>
              </div>
              <div class="form-check">
              <label class="form-check-label">
                  <input type="radio" value="f" class="form-check-input" name="sex" id="optionsRadios2">
                  Female
                </label>
              </div>
            </fieldset>
            <fieldset class="form-group">
              <legend>Please Choose</legend>
              <div class="form-check">
                <label class="form-check-label">
                  <input type="radio" value="0-5" class="form-check-input" name="age" id="optionsRadios1">
                  0 - 5
                </label>
              </div>
              <div class="form-check">
              <label class="form-check-label">
                  <input type="radio" value="5-18" class="form-check-input" name="age" id="optionsRadios2">
                  5 - 18
                </label>
              </div>
              <div class="form-check">
                <label class="form-check-label">
                  <input type="radio" value="18+" class="form-check-input" name="age" id="optionsRadios2">
                  18+
                </label>
              </div>
            </fieldset>
            <div class="form-check">
              <label class="form-check-label">
                <input type="text"  name="nationality" value="1" class="form-check-input" id="nationality">
                Nationality
              </label>
            </div>
            <div class="form-check">
              <label class="form-check-label">
                <input type="checkbox"  name="needs_protection"  value="1" class="form-check-input" id="scabies">
                Needs Protection
              </label>
            </div>
            <div class="form-check">
              <label class="form-check-label">
                <input type="checkbox"  name="medical_case" value="1"  class="form-check-input" id="medical_case">
                Medical Case
              </label>
            </div>
            <div class="form-check">
              <label class="form-check-label">
                <input type="checkbox" class="form-check-input" name="scabies" value="1" id="scabies">
                Scabies
              </label>
            </div>
            <div class="form-check">
              <label class="form-check-label">
                <input type="checkbox" class="form-check-input" name="alone_traveling_woman" value="1" id="scabies">
                Alone traveling woman
              </label>
            </div>
            <div class="form-check">
              <label class="form-check-label">
                <input type="checkbox" class="form-check-input" name="unaccopanied_minor" value="1" id="scabies">
                Unaccopanied minor
              </label>
            </div>
            <div class="form-check">
              <label class="form-check-label">
                <input type="checkbox" class="form-check-input" name="pregnant_woman" value="1" id="scabies">
                Pregnant Woman
              </label>
            </div>
            <button type="submit" name="submitted" class="btn btn-primary">Submit</button>
          </form>

        </div>
      </div>
    </div>
    <!-- Page Content -->
    <div class="container overview_toggle" style="display:none">
      <div class="row">
        <div class="col-lg-12">


          <table class="table-striped" style="width:100%">
            <tbody>
            <?php

            $boats_count = [];
            foreach($boats AS $boat){



              //create initial array with boat information
              $boat_array = array('id'=>$boat['id'],'active'=>$boat['active'],'scabies'=>0,'medical_case'=>0,'needs_protection'=>0,'male'=>0,'female'=>0);
              //get people from boat
              $persons_on_board = $db->select('people_on_board', array('boat_id', $boat['id']));
              foreach($persons_on_board AS $person_on_board){

                //add counts to boat id
                if($person_on_board['scabies'])
                  $boat_array['scabies']++;
                if($person_on_board['medical_case'])
                  $boat_array['medical_case']++;
                if($person_on_board['needs_protection'])
                  $boat_array['needs_protection']++;
                if($person_on_board['sex'] == 'm')
                  $boat_array['male']++;
                if($person_on_board['sex'] == 'f')
                  $boat_array['female']++;
              }
              //push to final array
              $boats_count[$boat->timestamp.' '.$boat['boat_code']] = $boat_array;
            }?>

              <tr>
                <td>Boat</td>
                <td>Male</td>
                <td>Female</td>
                <td>Medical Cases</td>
                <td>Scabies</td>
                <td>Needs Protection</td>
                <td>Archive</td>
              </tr>
            <?php
            foreach($boats_count AS $index=>$boat_count){
              ?>
              <tr>
                <td><?php echo  $index?></td>
                <td><?php echo  $boat_count['male']?></td>
                <td><?php echo  $boat_count['female']?></td>
                <td><?php echo  $boat_count['medical_case']?></td>
                <td><?php echo  $boat_count['scabies']?></td>
                <td><?php echo  $boat_count['needs_protection'];?></td>
                <?php
                if($boat_count['active'] == 1){
                  ?>
                <td><a href="?action=deactivateBoat&id=<?php echo  $boat_count['id']?>">file to archive</a></td>
                <?php
                  }
                else if($boat_count['active'] == 0){
                  ?>
                <td><a href="?action=reactivateBoat&id=<?php echo  $boat_count['id']?>">set active</a></td>
                <?php
                  }
                  ?> 
              </tr>
              <?php
            }
            ?>
            </tbody>
          </table>
          <a href="#" style="margin-top:30px;">also show archived boats</a>
        </div>


      </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script>

    function toggleViews(){
      $('.overview_toggle').toggle(); $('.nav-item').toggleClass('active');
    }

    $(document).ready(function(){


      var hash = window.location.hash;

      if(window.location.hash == '#overView')
        toggleViews();


      
    });

    </script>

  </body>

</html>
