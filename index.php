<?php 
define("SITE_ADDR","http://localhost/TREE_MAP/?search=&submit=");

$site_title='Search Engine|Aditi';
?>
<!DOCTYPE html>
<html>
<head>
  <title>Search</title>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"> 
</head>
<body>
<div id="wrapper">

<div id="top-header">
<div id="nav">
    <a href="https://www.google.com/maps/d/edit?mid=121d6Ke8vnLSwFYV0BNel0e4WyZOVit0&usp=sharing" style="color:#fff">All_Tree_Map</a>
</div>
<div id="logo">
<center><h1><a href="<?php echo SITE_ADDR;?>"><h1>Tree&earch</h1></a></h1></center>
</div>
</div>

<div id="main" class="shadow-box"><div id="content">
<center>
<form action="" method="GET" name="">

  <i class="fa-solid fa-magnifying-glass-location"></i>
  <input type="text" name="search" id="box1" value="<?php echo isset($_GET['k']) ? $_GET['k'] : ''; ?>" placeholder="Enter Tree name or location" />
  <button type="submit" name="submit" id="box2">Search</button>
</form> 
 

<?php
  //$button = $_GET ['submit'];
 

  // connect to database
  if(isset($_GET['search'])&& $_GET['search']!=''){

    $search = $_GET ['search'];
  $con=mysqli_connect("localhost","root","","treedetail");
 // ALTER TABLE `treedetail` ADD FULLTEXT(TreeName,location,About);
 // ALTER TABLE `treedetail`.`treedetail` DROP INDEX `TreeName`, ADD FULLTEXT `TreeName` (`TreeName`, `location`, `About`);
    $sql ="SELECT * FROM treedetail WHERE MATCH(TreeName,location,About) AGAINST ('%" . $search . "%')";

    $run = mysqli_query($con,$sql);
    
    $foundnum = mysqli_num_rows($run);


    if ($foundnum==0)
    {
      echo "No Tree found with a search term of '<b>$search</b>'.";
    }
    else{
      echo "<h3><strong> $foundnum Results Found for \"" .$search."\" </strong></h3>";      

      // get num of results stored in database
      $sql = "SELECT * FROM treedetail WHERE MATCH(TreeName,location,About) AGAINST ('%" . $search . "%')";
      $getquery = mysqli_query($con,$sql);
      echo '<div class="scroll-bar"><table class="search">';
      while($runrows = mysqli_fetch_array($getquery))
      {
        $buyLink = $runrows["TreeName"];
        $imageLink = $runrows["location"];
        echo '<tr>
			<td><h2><a href="'.$runrows['map'].'"><h2>'.$runrows['TreeName'].'</h2></a></h2></td>
		</tr>
		<tr>
			<td><b> location- '.$runrows['location'].'</b></td>
		</tr>
		<tr>
			<td><i>'.$runrows['About'].'</i></td>
		</tr>';

        }
        echo '</table></div>';}
       

    mysqli_close($con);}
    else
    echo '<h4>No results found. Try searching for something else.</h4>';
?>
</center>
</body>
</html>