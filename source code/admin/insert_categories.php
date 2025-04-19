<?php
  include("../includes/connect.php");
  if(isset($_POST['Insert_categories'])){
    $category_title = $_POST['Cat_title']; // Fixed variable name

    // select data from database
    $select_query="select * from `categories` where category_title='$category_title'";
    $result_select=mysqli_query($con,$select_query);
    $number=mysqli_num_rows($result_select);
    if($number>0){
      echo "<script>alert('Categories already exist')</script>";
      return; // Stop further execution if category already exists
    }

    // insert data into database
    $insert_query="insert into `categories` (category_title) values ('$category_title')";
    $result=mysqli_query($con,$insert_query); // Fixed variable name
    if($result){
      echo "<script>alert('Categories has been inserted successfully')</script>";
    }
  }
?>

<h2 class="text-center">Insert Categories</h2>
<form action="" method="post" class="mb-2">
<div class="input-group w-90 mb-2">
  <span class="input-group-text bg-info" id="basic-addon1"><i class="fa-solid fa-receipt"></i></span>
  <input type="text" class="form-control" name="Cat_title" placeholder="Insert Categories" aria-label="categories" aria-describedby="basic-addon1">
</div>
<div class="input-group w-10 mb-2 m-auto">
  <input type="submit" class="bg-info border-0 p-2 my-3" name="Insert_categories" value="Insert Categories">
</div>
</form>