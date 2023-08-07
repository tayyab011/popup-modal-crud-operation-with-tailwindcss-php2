<?php
include_once("./conn.php");

if (isset($_POST['upbutton'])) {
    $preid = bap($_POST['preid']);
    $uname = bap($_POST['uname']);
    $uemail = bap($_POST['uemail']);
    $upassword = bap($_POST['upassword']);
    $uphone = bap($_POST['uphone']);
   


if (empty($uname)) {
  $ename ="fillup your name";
}elseif(!preg_match('/^[A-Za-z\s]+$/',$uname)){
  $ename ="invalid name";
}else{
    $crrname = $conn->real_escape_string($uname);
}


if (empty($uemail)) {
  $eemail ="fillup your email";
}elseif(!filter_var($uemail, FILTER_VALIDATE_EMAIL)){
  $eemail ="invalid email";
}else{
    $crremail = $conn->real_escape_string($uemail);
}

if (empty($upassword)) {
  $epass ="fillup your email";
}elseif(strlen($upassword)<6){
  $epass ="please write a 6 digite strong password";
}else{
    $crrpass = $conn->real_escape_string($upassword);
}

if (empty($uphone)) {
  $ephone ="fillup your email";
}elseif(!preg_match('/^\+?\d{7,15}$/',$uphone)){
  $ephone ="please write a 6 digite strong phone";
}else{
    $crrphone = $conn->real_escape_string($uphone);
}

if (isset($_POST['ugender'])) {
        $ugender = bap($_POST['ugender']);
        $genderOptions = array("male", "female");
        if (!in_array($ugender, $genderOptions)) {
            $egender = "Invalid gender";
        } else {
            $crrgender = $conn->real_escape_string($ugender);
        }
    } else {
        $egender = "Fill up your gender"; 
       
    }

if (isset($crrname) && isset($crremail) && isset($crrpass) && isset($crrphone) && isset($crrgender) ){
    $update = $conn->query("UPDATE `pt2` SET `name`='$uname', `email`='$uemail', `password`='$upassword', `phone`='$uphone', `gender`='$ugender' WHERE `id`= $preid");

    if ($update) {
       echo "<div style='margin:auto;text-align:center;width:500px;height:40px;font-size:25px; color:white;background:black;'>data submitted successfully</div>";
        echo "<script>setTimeout(()=>{location.href='./index';},1000)</script>";
    } else {
        echo "<div style='margin:auto;text-align:center;width:500px;height:40px;font-size:25px; color:white;background:red;'>data is not submitted</div>";
    }
}
}
/* delete modal query */
if (isset($_POST['delbutton'])) {
     $delid=bap($_POST['delid']);
    $delete = $conn->query("DELETE FROM `pt2` WHERE `id`=$delid");
    if ($delete) {
       echo "<div style='margin:auto;text-align:center;width:500px;height:40px;font-size:25px; color:black;background:gray;margin-bottom:8px;'>your data deleted</div>";
        echo "<script>setTimeout(()=>{location.href='./index';},1000)</script>";
    } else {
        echo "<div style='margin:auto;text-align:center;width:500px;height:40px;font-size:25px; color:white;background:red;'>data is not deleted.try again</div>";
    }
}
?>

<table class="table-auto w-full border-collapse border bg-white">
    <thead>
        <tr>
            <th class="py-2 bg-gray-800 text-white">sn</th>
            <th class="px-4 py-2 bg-gray-800 text-white">name</th>
            <th class="px-4 py-2 bg-gray-800 text-white">email</th>
            <th class="px-4 py-2 bg-gray-800 text-white">password</th>
            <th class="px-4 py-2 bg-gray-800 text-white">phone</th>
            <th class="px-4 py-2 bg-gray-800 text-white">gender</th>
            <th class="px-4 py-2 bg-gray-800 text-white">operation</th>
        </tr>
    </thead>
    <?php
    $dd = $conn->query("SELECT * FROM `pt2`");
    if ($dd->num_rows > 0) {
        $sn = 1;
        while ($row = mysqli_fetch_assoc($dd)) {
            $row_id = $row['id'];
            ?>
            <tbody>
                <tr class="bg-gray-200 hover:bg-gray-400">
                    <td class="border py-2 text-center"><?= $sn; ?></td>
                    <td class="border px-4 py-2"><?= $row['name'] ?></td>
                    <td class="border px-4 py-2"><?= $row['email'] ?></td>
                    <td class="border px-4 py-2"><?= $row['password'] ?></td>
                    <td class="border px-4 py-2"><?= $row['phone'] ?></td>
                    <td class="border px-4 py-2"><?= $row['gender'] ?></td>
                    <td class="border px-4 py-2">
                        <a id="updatemodal-<?= $row_id ?>" class="bg-blue-600 hover:bg-blue-400 text-white font-bold py-2 px-4 rounded mx-auto md:px-8 lg:px-4 cursor-pointer" onclick="openModal(<?= $row['id'] ?>)">
                            update
                        </a>
                        <a id="deletemodal-<?= $row_id ?>" class="ml-2 bg-red-600 hover:bg-red-400 text-white font-bold py-2 px-4 rounded mx-auto md:px-8 lg:px-4 cursor-pointer" onclick="opendelModal(<?= $row['id'] ?>)">
                            Delete
                        </a>
                    </td>
                </tr>
            </tbody>
            <!-- upmodal -->
             <div id="upModal-<?= $row_id ?>" class="overflow-y-auto fixed inset-0 flex items-center justify-center z-10 hidden">
            <div class="absolute inset-0 bg-gray-900 opacity-50 "></div>
            <div id='modal' class=" bg-white p-8 rounded shadow-lg z-20 w-full md:w-1/2 mx-5">
                <h2 class="text-2xl font-semibold mb-4 mt-5 text-center">Upload Id</h2>
                <form class='mx-auto' method='post' onsubmit="return validateForm(<?= $row_id ?>);">
                    <input type='hidden' id='preid' name='preid' value="<?= $row_id ?>" />
                    <div class="w-full flex items-center gap-2">
                        <i class="w-6 fa-solid fa-user"></i>
                        <div class="md:w-full">
                            <label for='Name'>Name:</label><br>
                            <input type='text' placeholder='write your name' name='uname' value='<?= $row['name'] ?>' class='md:w-72 w-72 border-2 focus:border-red-500 focus:outline-none rounded'>
                        </div>
                    </div>
                    <p class='text-red-500 ml-7 font-semibold'><?= $ename ?? null ?></p>
                    <br>
                    <div class="w-full flex items-center gap-2">
                        <i class="w-6 fa-solid fa-envelope"></i>
                        <div class="md:w-full">
                            <label for='email'>Email:</label><br>
                            <input type='text' placeholder='write your email' name='uemail' value='<?= $row['email'] ?>' class='md:w-72 w-72 border-2 focus:border-red-500 focus:outline-none rounded'>
                        </div><br>
                    </div>
                    <p class='text-red-500 ml-7 font-semibold'><?= $eemail ?? null ?></p> <br>
                    <div class="w-full flex items-center gap-2">
                        <i class="w-6 fa-solid fa-lock"></i>
                        <div class="md:w-full">
                            <label for='password'>Password:</label><br>
                            <input type='password' placeholder='write your password' name='upassword' value='<?= $row['password'] ?>' class='md:w-72 w-72 border-2 focus:border-red-500 focus:outline-none rounded'>
                        </div><br>
                    </div><p class='text-red-500 ml-7 font-semibold'><?= $epass ?? null ?></p><br>
                    <div class="w-full flex items-center gap-2">
                        <i class="w-6 fa-solid fa-phone"></i>
                        <div class="md:w-full">
                            <label for='phone'>Phone:</label><br>
                            <input type='phone' placeholder='write your phone' name='uphone' value='<?= $row['phone'] ?>' class='md:w-72 w-72 border-2 focus:border-red-500 focus:outline-none rounded'>
                        </div><br>
                    </div><p class='text-red-500 ml-7 font-semibold'><?= $ephone ?? null ?></p><br>
                    <div class="w-full flex items-center gap-2">
                        <i class="w-6 fa-solid fa-person"></i>
                        <div class="md:w-1/2 w-full gap-3 flex">
                            <label for='gender'>Gender:</label><br>
                            <input type='radio' name='ugender' class='md:w-72  border-2 focus:border-red-500 focus:outline-none rounded' value='male'>male
                            <input type='radio' name='ugender' class='md:w-72  border-2 focus:border-red-500 focus:outline-none rounded' value='female'>female
                        </div><br>
                    </div><p class='text-red-500 ml-7 font-semibold'><?= $egender ?? null ?></p><br><br>
                    <div class="dick relative ">
                        <button type='submit' name='upbutton' class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                            Update
                        </button>
                        <button type="button" onclick="closeModal(<?= $row_id ?>)" class="bg-blue-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded absolute right-0">
                            Close Modal
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- upmodal -->

<!-- delete modal -->
 <div id="deletemodal-<?= $row_id ?>" class="overflow-y-auto fixed inset-0 flex items-center justify-center z-10 hidden">
            <div class="absolute inset-0 bg-gray-900 opacity-50 "></div>
            <div id='modal' class=" bg-white p-8 rounded shadow-lg z-20 w-full md:w-1/2 mx-5">
                <h2 class="text-2xl font-semibold mb-4 mt-5 text-center">Upload Id</h2>
                <form class='mx-auto' method='post'>
                    <input type='hidden' name='delid' value="<?= $row_id ?>" />
                    Do you want to Delete this id?
                    <div class="dick relative ">
                        <button type='submit' name='delbutton' class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                            delete
                        </button>
                        <button type="button" onclick="closedelModal(<?= $row_id ?>)" class="bg-blue-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded absolute right-0">
                            Close 
                        </button>
                    </div>
                </form>
            </div>
        </div>
<!-- delete modal -->




            <?php
            $sn++;
        }
    }
    ?>
</table>



<script>
    function openModal(id) {
        const upModal = document.getElementById(`upModal-${id}`);
        upModal.classList.remove("hidden");
    }

    function closeModal(id) {
        const upModal = document.getElementById(`upModal-${id}`);
        upModal.classList.add("hidden");
    }
 
 function validateForm(id) {
        // Your client-side validation code here

        // Example: You can use the following code to show validation errors in the modal
        const modal = document.getElementById(`upModal-${id}`);
        const nameInput = modal.querySelector('input[name="uname"]');
        const emailInput = modal.querySelector('input[name="uemail"]');
        const passwordInput = modal.querySelector('input[name="upassword"]');
        const phoneInput = modal.querySelector('input[name="uphone"]');
        const genderInput = modal.querySelector('input[name="ugender"]:checked');

        let isValid = true;

        // Your validation conditions for each field here
        if (!nameInput.value.trim()) {
            alert("Please fill up your name.");
            isValid = false;
        }

        if (!emailInput.value.trim()) {
            alert("Please fill up your email.");
            isValid = false;
        }

        if (!passwordInput.value.trim()) {
            alert("Please fill up your password.");
            isValid = false;
        }

        if (!phoneInput.value.trim()) {
            alert("Please fill up your phone.");
            isValid = false;
        }

        if (!genderInput) {
            alert("Please select your gender.");
            isValid = false;
        }

        return isValid;
    }




/* delete modals script */

  function opendelModal(id) {
        const deletemodal = document.getElementById(`deletemodal-${id}`);
        deletemodal.classList.remove("hidden");
    }

    function closedelModal(id) {
        const deletemodal = document.getElementById(`deletemodal-${id}`);
        deletemodal.classList.add("hidden");
    }
</script>
