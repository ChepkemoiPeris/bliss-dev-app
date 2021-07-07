<?php
 include "conn.php"; 
 ?> 


<!doctype html>
<html lang="en">

<head>
    <title>Hospital System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h2>Patient Information</h2>
        <form method="post" id="patient_form">
            <div class="form-group">
                <label for="">Full Name</label>
                <input type="text" class="form-control" name="name" id="name"placeholder="Enter Full Name" required>
            </div>
            <div class="form-group">
                <label for="">Date Of Birth</label>
                <input type="date" class="form-control" name="dob" id="dob"  value="max=<?php echo date("Y-m-d"); ?>" placeholder="Enter Date of Birth" required>
            </div>
            <div class="form-group">
                <label for="">Gender</label>
                <select class="form-control" name="gender" id="gender" required>
                <option selected disabled>Select Gender</option>
                 <?php
                  
                   $sql="SELECT * FROM gender";
                foreach ($conn->query($sql) as $row){
                              echo "<option value=$row[id]>$row[gender]</option>"; 
                                    }
                                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="">Type of Service</label>
                <select class="form-control" name="service" id="service" required>
                <option selected disabled>Select Service</option>
                 <?php
                    
                   $sql="SELECT * FROM tbl_service";
                foreach ($conn->query($sql) as $row){
                              echo "<option value=$row[id]>$row[service]</option>"; 
                         }
                 ?>
                </select>
            </div>
            <div class="form-group">
                <label for="">General Comments</label>
                <textarea class="form-control" name="comments" id="comments" rows="3" placeholder="Comments" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary" onclick="register(event)">Submit</button>
        </form>
        <div class="card card-preview">

            <div class="card-inner">
                <table class="datatable-init table ">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name </th>
                            <th>Date of Birth</th>
                            <th>Gender</th>
                            <th>Type of Service</th>
                            <th>General Comments</th> 
                        </tr>
                    </thead>
                    <tbody id="patient">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"
        integrity="sha512-bZS47S7sPOxkjU/4Bt0zrhEtWx0y0CRkhEp8IckzK+ltifIIE9EMIMTuT/mEzoIMewUINruDBIR/jJnbguonqQ=="
        crossorigin="anonymous"></script>
    <script> 

        register = async (e) => {
            e.preventDefault()
            var name = document.getElementById("name").value;
            var dob = document.getElementById("dob").value;
            var gender = document.getElementById("gender").value;
            var service = document.getElementById("service").value;
            var comments = document.getElementById("comments").value;
            let fd = new FormData();
            fd.append("name", name) 
            fd.append("gender", gender)
            fd.append("dob", dob)
            fd.append("service", service)
               fd.append("comments", comments)
            fd.append("register", 1)   
            let resp = await axios.post('register_patient.php', fd);  
            console.log(resp.data)      
            if (resp.data.success) {
                alert("Successfully Added")
                $('#patient_form')[0].reset();
                load()
            }     

    }
    var patients = [] 
    loadPatients = async () =>{ 
        let resp = await axios.get('get_patients.php?get_patients');        
         console.log(resp.data)      

        if(resp.data.success){
            let rows = ''
            let i = 1
            resp.data.patients.forEach(h => {
            rows +=
                `<tr>  
                            <td> ${i++}</td>
                            <td> ${h.full_name}</td>
                            <td> ${h.dob}</td>
                            <td> ${h.gender_name}</td>                            
                            <td> ${h.service_name}</td>                            
                            <td> ${h.comment}</td>
                            <td class="text-center"> <em class="icon ni ni-pen edit" id="edit_btn" onclick="update(${h.id})" role="button"></em> 
                             <em class="p-3 icon ni ni-trash text-danger"  onclick="deletep(${h.id})" role="button"></em></td>`
             })

            document.getElementById('patient').innerHTML = rows
        }
 
    }

    load = async function() {
        await loadPatients()
    }
    load()
    </script>

</body>

</html>