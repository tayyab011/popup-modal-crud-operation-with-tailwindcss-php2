<?php
include_once("./conn.php");

if (isset($_POST['button'])) {
 $name =bap($_POST['name']);
 $email =bap($_POST['email']);
 $password =bap($_POST['password']);
 $phone =bap($_POST['phone']);
 



if (empty($name)) {
  $ename ="fillup your name";
}elseif(!preg_match('/^[A-Za-z\s]+$/',$name)){
  $ename ="invalid name";
}else{
    $crrname = $conn->real_escape_string($name);
}


if (empty($email)) {
  $eemail ="fillup your email";
}elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
  $eemail ="invalid email";
}else{
    $crremail = $conn->real_escape_string($email);
}

if (empty($password)) {
  $epass ="fillup your email";
}elseif(strlen($password)<6){
  $epass ="please write a 6 digite strong password";
}else{
    $crrpass = $conn->real_escape_string($password);
}

if (empty($phone)) {
  $ephone ="fillup your email";
}elseif(!preg_match('/^\+?\d{7,15}$/',$phone)){
  $ephone ="please write a 6 digite strong phone";
}else{
    $crrphone = $conn->real_escape_string($phone);
}

if (isset($_POST['gender'])) {
        $gender = bap($_POST['gender']);
        $genderOptions = array("male", "female");
        if (!in_array($gender, $genderOptions)) {
            $egender = "Invalid gender";
        } else {
            $crrgender = $conn->real_escape_string($gender);
        }
    } else {
        $egender = "Fill up your gender";
    }

    if (isset($crrname) && isset($crremail) && isset($crrpass) && isset($crrphone) && isset($crrgender) ) {
      $insert= $conn->query("INSERT INTO `pt2` (`name`,`email`,`password`,`phone`,`gender`) VALUES ('$crrname', '$crremail','$crrpass','$crrphone','$crrgender')");
if ($insert) {
  $di ="<div style='margin:auto;text-align:center;width:500px;height:40px;font-size:25px; color:white;background:black;'>data submite successfull</div>";
  echo "<script>setTimeout(()=>{
    location.href='./index'
  },1500)
  </script>";
 
}else{
  $di ="data isnot submit";
}
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
  label {
  color: red;
}
#modal{
  overflow-y:auto;
  
}
</style>
</head>
<body>
    <!-- Button to trigger the modal -->
<div class="dic flex mt-6">
    <button id="openModal" class="bg-red-600 hover:bg-red-400 text-white font-bold py-2 px-4 rounded mx-auto md:px-8 lg:px-4 mb-5">
  Add Data
</button>
</div>
 <?= $di ?? null ?>

<?php include_once("./display.php")?>

<!-- Modal container -->
<div id="myModal" class="overflow-y-auto  fixed inset-0 flex items-center justify-center z-10 hidden">
  <div class="absolute inset-0 bg-gray-900 opacity-50 "></div> <!-- Overlay -->
  <div id='modal' class=" bg-white p-8 rounded shadow-lg z-20 w-full md:w-1/2 mx-5">
    <!-- Modal content goes here -->
    <h2 class="text-2xl font-semibold mb-4 mt-5 text-center">Modal Title</h2>
    <form class='mx-auto' method='post'>
      <div class="w-full flex items-center gap-2">
        <i class="w-6 fa-solid fa-user"></i>
        <div class="md:w-full">
          <label for='Name'>Name:</label><br>
          <input type='text' placeholder='write your name' name='name' class='md:w-72 w-72 border-2 focus:border-red-500 focus:outline-none rounded'>
        </div>
      </div>
     <p class='text-red-500 ml-7 font-semibold'><?= $ename ?? null ?></p> 
      <br>
       <div class="w-full flex items-center gap-2">
        <i class="w-6 fa-solid fa-envelope"></i>
        <div class="md:w-full">
          <label for='email'>Email:</label><br>
          <input type='text' placeholder='write your email' name='email' class='md:w-72 w-72 border-2 focus:border-red-500 focus:outline-none rounded'>
        </div><br>
      </div>
      <p class='text-red-500 ml-7 font-semibold'><?= $eemail ?? null ?></p> <br>
      <div class="w-full flex items-center gap-2">
       <i class="w-6 fa-solid fa-lock"></i>
        <div class="md:w-full">
          <label for='password'>Password:</label><br>
          <input type='password' placeholder='write your password' name='password' class='md:w-72 w-72 border-2 focus:border-red-500 focus:outline-none rounded'>
        </div><br>
      </div><p class='text-red-500 ml-7 font-semibold'><?= $epass ?? null ?></p><br>
      <div class="w-full flex items-center gap-2">
       <i class="w-6 fa-solid fa-phone"></i>
        <div class="md:w-full">
          <label for='phone'>Phone:</label><br>
          <input type='phone' placeholder='write your phone' name='phone' class='md:w-72 w-72 border-2 focus:border-red-500 focus:outline-none rounded'>
        </div><br>
      </div><p class='text-red-500 ml-7 font-semibold'><?= $ephone ?? null ?></p><br>
      <div class="w-full flex items-center gap-2">
       <i class="w-6 fa-solid fa-person"></i>
        <div class="md:w-1/2 w-full gap-3 flex">
          <label for='gender'>Gender:</label><br>
          <input type='radio' name='gender' class='md:w-72  border-2 focus:border-red-500 focus:outline-none rounded' value='male'>male
          <input type='radio' name='gender' class='md:w-72  border-2 focus:border-red-500 focus:outline-none rounded' value='female'>female
        </div><br>
      </div><p class='text-red-500 ml-7 font-semibold'><?= $egender ?? null ?></p><br><br>
      
    
      <div class="dick relative ">
     <button type='submit' name='button'  class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded ">
      submit
    </button>
    <button id="closeModal" class="bg-blue-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded absolute right-0">
      Close Modal
    </button>
   </div>
    </form>
   
  </div>
</div>
<!-- modal end -->




<script>
  const openModalButton = document.getElementById("openModal");
  const closeModalButton = document.getElementById("closeModal");
  const modal = document.getElementById("myModal");

  openModalButton.addEventListener("click", () => {
    
    modal.classList.remove("hidden");
  });

  closeModalButton.addEventListener("click", () => {
    
    modal.classList.add("hidden");
  });
</script>

</body>
</html>