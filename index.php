<?php
error_reporting(0);
include('./db_class.php');
include('functions.php');






$db = new db();


function getPersonsForBoat($boat_id){
  $db->select();
}

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
    <link href="./vendor/jquery-ui/jquery-ui.css" rel="stylesheet">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <style>
      body {
        padding-top: 54px;
      }
    
    .trick-inline .form-check { 
      float:left; padding-right:15px;
    }
    .archived{
      display:none;
    }
    .form-check.nation {margin-bottom:1.5rem;}
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

$boats = getBoats();
?>
          <form action="./" method="post">
            <fieldset class="form-group">
              <legend><a href="?action=addBoat">+</a>Boat</legend>
              <div class="form-check">
                <label class="form-check-label">
                <?php
                echo '<select name="boat">';
                foreach($boats AS $boat){
                  if($boat['active'] == 1)
                  echo '<option value="'.$boat['id'].'">'.getBoatTitle($boat).'</option>';
                }
                echo '</select>';
                ?>
                </label>
              </div>
            </fieldset>
            <fieldset class="form-group trick-inline">
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
            <fieldset class="form-group trick-inline">
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
            <div class="form-check nation">
              <label class="form-check-label">
                <input type="text"  name="nationality" placeholder="nationality" class="form-check-input" id="nationality">
                Nationality
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


              unset($boat_array);
              //create initial array with boat information
              $boat_array = array('id'=>$boat['id'],'active'=>$boat['active'],'pregnant_woman'=>0,'alone_traveling_woman'=>0,'unaccopanied_minor'=>0,'male'=>0,'female'=>0);

              $nationalities = array();
              //get people from boat
              $persons_on_board = $db->shiftResult($db->select('people_on_board', array('boat_id', $boat['id']), null, array('id', 'DESC')),'id');
              foreach($persons_on_board AS $person_on_board){

                //add counts to boat id
                if($person_on_board['pregnant_woman'])
                  $boat_array['pregnant_woman']++;
                if($person_on_board['alone_traveling_woman'])
                  $boat_array['alone_traveling_woman']++;
                if($person_on_board['unaccopanied_minor'])
                  $boat_array['unaccopanied_minor']++;
                if($person_on_board['sex'] == 'm')
                  $boat_array['male']++;
                if($person_on_board['sex'] == 'f')
                  $boat_array['female']++;

                $nationality = $person_on_board['nationality'];


                if($nationality == '')
                    $nationality = 'unknown';

                if($nationalities[$nationality]){
                  $nationalities[$nationality]++;
                }else{
                 $nationalities[$nationality] = 1;
                }
              }

              $boat_array['nationalities'] = $nationalities;

              //push to final array
              $title = getBoatTitle($boat);
              $boats_count[$title] = $boat_array;
            }
            ?>
              <tr>
                <td>Boat</td>
                <td>Male</td>
                <td>Female</td>
                <td>Alone Traveling Woman</td>
                <td>pregnant_woman</td>
                <td>unaccopanied_minor</td>
                <td>Nationalities</td>
                <td>Archive</td>
              </tr>
            <?php
            foreach($boats_count AS $index=>$boat_count){
              $class = '';

              if($boat_count['active'] != 1){
                $class = 'archived';
              }
              ?>
              <tr class="<?php echo $class;?>">
                <td><a href=""><?php echo  $index?></a></td>
                <td><?php echo  $boat_count['male']?></td>
                <td><?php echo  $boat_count['female']?></td>
                <td><?php echo  $boat_count['pregnant_woman']?></td>
                <td><?php echo  $boat_count['alone_traveling_woman']?></td>
                <td><?php echo  $boat_count['unaccopanied_minor']?></td>
                <td>

                <?php

                foreach($boat_count['nationalities'] AS $name => $count){
                  echo $name.' - '.$count.'<br/>';
                }
                ?>

                </td>
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

          <div class="boat_details">

          </div>
          <a href="#" style="margin-top:30px;" onclick="$('.archived').show()">also show archived boats</a>
        </div>


      </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/jquery-ui/jquery-ui.js"></script>
    <script src="vendor/popper/popper.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script>
    $( function() {
      var availableTags = [
        'Nigeria',
        'Syria',
        'Bangladesh',
        'Libya',
    'Namibia',
    'Gambia',
        'Somalia',
        'Eritrea',
        'Marocco', 
    'Tunesia',
        'Mali',
        'Ivory coast'
      ];
      $( "#nationality" ).autocomplete({
        source: availableTags
      });
    } );
    </script>
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