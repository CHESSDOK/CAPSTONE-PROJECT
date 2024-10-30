<?php
include '../../php/conn_db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input data
    $id = $_POST['id'];
    $lastName = htmlspecialchars($_POST['lastName'] ?? '');
    $firstName = htmlspecialchars($_POST['firstName'] ?? '');
    $middleName = htmlspecialchars($_POST['middleName'] ?? '');
    $suffix = htmlspecialchars($_POST['Prefix'] ?? '');
    $dob = $_POST['dob'] ?? '';
    $pob = htmlspecialchars($_POST['pob'] ?? '');
    $religion = htmlspecialchars($_POST['religion'] ?? '');
    $houseadd = htmlspecialchars($_POST['houseadd'] ?? '');
    $civilStatus = htmlspecialchars($_POST['civilStatus'] ?? '');
    $sex = htmlspecialchars($_POST['sex'] ?? '');
    $height = htmlspecialchars($_POST['height'] ?? '');
    $tin = htmlspecialchars($_POST['tin'] ?? '');
    $sssNo = htmlspecialchars($_POST['sssNo'] ?? '');
    $pagibigNo = htmlspecialchars($_POST['pagibigNo'] ?? '');
    $philhealthNo = htmlspecialchars($_POST['philhealthNo'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $contactNo = htmlspecialchars($_POST['contactNo'] ?? '');
    $landline = htmlspecialchars($_POST['landline'] ?? '');
    $pwd = htmlspecialchars($_POST['pwd'] ?? '');
    $pwd2 = htmlspecialchars($_POST['pwd2'] ?? '');
    $fourPs = htmlspecialchars($_POST['four-ps-beneficiary'] ?? '');
    $household_id  = htmlspecialchars($_POST['household_id'] ?? '');
    $employment_status = htmlspecialchars($_POST['employent_status'] ?? '');
    $es_status =  htmlspecialchars($_POST['es_status'] ?? '');
    $es_others  = htmlspecialchars($_POST['es_others'] ?? '');
    $actively_looking = htmlspecialchars($_POST['actively-looking'] ?? '');
    $al_details  = htmlspecialchars($_POST['al_details'] ?? '');
    $willing_to_work = htmlspecialchars($_POST['willing_to_work'] ?? '');
    $ww_details  = htmlspecialchars($_POST['ww_detail'] ?? '');
    $passport = htmlspecialchars($_POST['passport_no'] ?? '');

    $school_name1 =  htmlspecialchars($_POST['school_name1'] ?? '');
    $school_name2 =  htmlspecialchars($_POST['school_name2'] ?? '');
    $school_name3 =  htmlspecialchars($_POST['school_name3'] ?? '');
    $school_name4 =  htmlspecialchars($_POST['school_name4'] ?? '');

    $year_grade1 =   htmlspecialchars($_POST['year_grad1'] ?? '');
    $year_grade2 =   htmlspecialchars($_POST['year_grad2'] ?? '');
    $year_grade3 =   htmlspecialchars($_POST['year_grad3'] ?? '');
    $year_grade4 =   htmlspecialchars($_POST['year_grad4'] ?? '');

    $award1 =  htmlspecialchars($_POST['award1'] ?? '');
    $award2 =  htmlspecialchars($_POST['award2'] ?? '');
    $award3 =  htmlspecialchars($_POST['award3'] ?? '');
    $award4 =  htmlspecialchars($_POST['award4'] ?? '');

    $course3 =  htmlspecialchars($_POST['course3'] ?? '');
    $course4 =  htmlspecialchars($_POST['course4'] ?? '');

    $level3 =  htmlspecialchars($_POST['level3'] ?? '');
    $level4 =  htmlspecialchars($_POST['level4'] ?? '');

    $year_level3 = isset($_POST['year_level3']) && !empty($_POST['year_level3']) ? $_POST['year_level3'] : NULL;
    $year_level4 = isset($_POST['year_level4']) && !empty($_POST['year_level4']) ? $_POST['year_level4'] : NULL;
    

    $passport_expiry = $_POST['passport_expiry'] ?? '';
    $salary = htmlspecialchars($_POST['salary'] ?? '');
    $jobs = isset($_POST['job']) ? $_POST['job'] : [];
    $pwl  = isset($_POST['pwl']) ? $_POST['pwl'] : [];
    $local =  isset($_POST['local']) ? $_POST['local'] : [];
    $overseas = isset($_POST['overseas']) ? $_POST['overseas'] : [];
    $profile_image = $_POST['existing_image'] ?? ''; // Retain the existing image
    $resume = $_POST['existing_resume'] ?? '';       // Retain the existing resume

    if (!empty($dob)) {
        $dobDate = new DateTime($dob);
        $currentDate = new DateTime();
        $age = $currentDate->diff($dobDate)->y; // Get the difference in years
    } else {
        $age = NULL; // Handle case where dob is empty
    }


    $local = array_filter($local);
    $local_string = implode(',', $local);

    $overseas  = array_filter($overseas);
    $overseas_string  = implode(',', $overseas);

    $jobs = array_filter($jobs);
    $job_string = implode(',', $jobs);

    // Handling selectedOptions input
    $selectedOptions = $_POST['selectedOptions'] ?? '';
    $optionsArray = explode(',', $selectedOptions); 
    $optionsString = implode(',', $optionsArray); 

    // Create directories for uploads if they don't exist
    $upload_dir = 'images/';
    $upload_dir_resume = 'resume/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }
    
    // Check and create the resume upload directory if it doesn't exist
    if (!is_dir($upload_dir_resume)) {
        mkdir($upload_dir_resume, 0777, true);
    }

    // Handle file uploads
    $profile_image = $_POST['existing_image'] ?? ''; // Retain the existing image
    $resume = $_POST['existing_resume'] ?? '';       // Retain the existing resume

    if (!empty($_FILES['profile_image']['name'])) {
        $profile_image = basename($_FILES['profile_image']['name']);
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $upload_dir . $profile_image);
    }
    if (!empty($_FILES['resume']['name'])) {
        $resume = basename($_FILES['resume']['name']);
        move_uploaded_file($_FILES['resume']['tmp_name'], $upload_dir_resume . $resume);
    }

    // Update applicant_profile
    $sql = "UPDATE applicant_profile SET 
                last_name = ?, 
                first_name = ?, 
                middle_name = ?, 
                prefix = ?, 
                dob = ?, 
                pob = ?, 
                age =  ?, 
                religion = ?, 
                house_address = ?, 
                civil_status = ?, 
                sex = ?, 
                height = ?, 
                tin = ?, 
                sss_no = ?, 
                pagibig_no = ?, 
                philhealth_no = ?, 
                email = ?,
                preferred_occupation = ?,
                school_name1 = ?,
                school_name2 = ?,
                school_name3 = ?,
                school_name4 = ?, 
                year_grad1 = ?,
                year_grad2 = ?,
                year_grad3 = ?,
                year_grad4 = ?,
                award1 = ?,
                award2 = ?,
                award3 = ?,
                award4 = ?,
                course3 = ?,
                course4 = ?,
                level3 = ?,
                level4 = ?,
                year_level3 = ?,
                year_level4 = ?,
                pwl  = ?, 
                overseas_loc = ?, 
                local_loc = ?, 
                contact_no = ?, 
                landline = ?, 
                pwd = ?, 
                pwd2 = ?, 
                four_ps = ?, 
                hhid =  ?, 
                selected_options = ?, 
                employment_status = ?, 
                es_status  = ?, 
                es_others  = ?, 
                actively_looking = ?, 
                al_details  = ?, 
                willing_to_work = ?, 
                ww_details = ?, 
                passport_no = ?, 
                passport_expiry = ?, 
                expected_salary = ?, 
                photo = IFNULL(?, photo), 
                resume = IFNULL(?, resume)
            WHERE user_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssssssssssssssssssssssssssiissssssssssssssssssssssi",
        $lastName, $firstName, $middleName, $suffix, $dob, $pob, $age, $religion, $houseadd, $civilStatus, $sex, $height, 
        $tin, $sssNo, $pagibigNo, $philhealthNo, $email, $job_string, $school_name1, $school_name2, $school_name3,
        $school_name4, $year_grade1, $year_grade2, $year_grade3, $year_grade4, $award1, $award2, $award3, $award4,
        $course3, $course4, $level3, $level4, $year_level3, $year_level4, $pwl, $overseas_string, $local_string, 
        $contactNo, $landline, $pwd, $pwd2, $fourPs, $household_id, $optionsString, $employment_status, $es_status, 
        $es_others, $actively_looking, $al_details, $willing_to_work, $ww_details, $passport, $passport_expiry, $salary,
        $profile_image, $resume, $id
    );

    if (!$stmt->execute()) {
        echo "Error updating profile: " . $stmt->error;
    }
    $stmt->close();

    // Function to insert data into a specified table
    function insertData($conn, $table, $fields, $values, $userId) {
        // Prepare the SQL statement
        $placeholders = implode(',', array_fill(0, count($fields), '?'));
        $sql = "INSERT INTO $table (" . implode(',', $fields) . ") VALUES ($placeholders)";
        $stmt = $conn->prepare($sql);
        
        // Bind parameters dynamically
        $stmt->bind_param(str_repeat('s', count($values)), ...$values);

        if (!$stmt->execute()) {
            echo "Error inserting record into $table: " . $stmt->error . "<br>";
        }
        $stmt->close();
    }

    // Insert into license table
    if (!empty($_POST['eligibility'])) {
        $eligibilities = $_POST['eligibility'] ?? [];
        $ratings = $_POST['rating'] ?? [];
        $exam_dates = $_POST['exam_date'] ?? [];
        $prc_files = $_FILES['license'] ?? [];

        $license_dir = 'license_files/';
        if (!is_dir($license_dir)) {
            mkdir($license_dir, 0777, true);
        }

        foreach ($eligibilities as $key => $eligibility) {
            if (!empty($eligibility)) {
                $rating = $ratings[$key] ?? '';
                $exam_date = $exam_dates[$key] ?? '';
                $prc_path = '';

                // Handle the PRC file upload
                if (!empty($prc_files['name'][$key])) {
                    $prc_file_name = basename($prc_files['name'][$key]);
                    $prc_file_path = $license_dir . $prc_file_name;
                    move_uploaded_file($prc_files['tmp_name'][$key], $prc_file_path);
                    $prc_path = $prc_file_path;
                }

                // Insert into license table
                insertData($conn, 'license', ['user_id', 'eligibility', 'rating', 'doe', 'prc_path'], [$id, $eligibility, $rating, $exam_date, $prc_path], $id);
            }
        }
    }


// Insert or Update Technical/Vocational Training
        if (!empty($_POST['training'])) {
            $trainings = $_POST['training'] ?? [];
            $start_dates = $_POST['start_date'] ?? [];
            $end_dates = $_POST['end_date'] ?? [];
            $institutions = $_POST['institution'] ?? [];
            $certificates = $_FILES['certificate'] ?? [];

            $training_dir = 'training_files/';
            if (!is_dir($training_dir)) {
                mkdir($training_dir, 0777, true);
            }

            foreach ($trainings as $key => $training) {
                if (!empty($training)) {
                    $start_date = $start_dates[$key] ?? '';
                    $end_date = $end_dates[$key] ?? '';
                    $institution = $institutions[$key] ?? '';
                    $certificate_path = '';

                    // Handle the certificate file upload only if a new file is provided
                    if (!empty($certificates['name'][$key])) {
                        $certificate_file_name = basename($certificates['name'][$key]);
                        $certificate_file_path = $training_dir . $certificate_file_name;
                        move_uploaded_file($certificates['tmp_name'][$key], $certificate_file_path);
                        $certificate_path = $certificate_file_path;  // New file uploaded
                    }

                    // Check if the training record exists for this user
                    $check_sql = "SELECT id, certificate_path FROM training WHERE user_id = ? AND training = ?";
                    $check_stmt = $conn->prepare($check_sql);
                    $check_stmt->bind_param("is", $id, $training);
                    $check_stmt->execute();
                    $check_result = $check_stmt->get_result();

                    if ($check_result->num_rows > 0) {
                        // Update the existing record
                        $row = $check_result->fetch_assoc();
                        $training_id = $row['id'];
                        $existing_certificate_path = $row['certificate_path'];  // Get the existing certificate

                        // If no new certificate is uploaded, retain the old one
                        if (empty($certificate_path)) {
                            $certificate_path = $existing_certificate_path;
                        }

                        $update_sql = "UPDATE training SET start_date = ?, end_date = ?, institution = ?, certificate_path = ? WHERE id = ?";
                        $update_stmt = $conn->prepare($update_sql);
                        $update_stmt->bind_param("ssssi", $start_date, $end_date, $institution, $certificate_path, $training_id);

                        if (!$update_stmt->execute()) {
                            echo "Error updating training record: " . $update_stmt->error;
                        }
                        $update_stmt->close();
                    } else {
                        // Insert new record
                        $insert_sql = "INSERT INTO training (user_id, training, start_date, end_date, institution, certificate_path) VALUES (?, ?, ?, ?, ?, ?)";
                        $insert_stmt = $conn->prepare($insert_sql);
                        $insert_stmt->bind_param("isssss", $id, $training, $start_date, $end_date, $institution, $certificate_path);

                        if (!$insert_stmt->execute()) {
                            echo "Error inserting training record: " . $insert_stmt->error;
                        }
                        $insert_stmt->close();
                    }
                    $check_stmt->close();
                }
            }
        }


    // Insert Language Proficiency
    if (!empty($_POST['language'])) {
        $languages = $_POST['language'] ?? [];
        $reads = $_POST['read'] ?? [];
        $writes = $_POST['write'] ?? [];
        $speaks = $_POST['speak'] ?? [];
        $understands = $_POST['understand'] ?? [];
    
        foreach ($languages as $key => $language) {
            if (!empty($language)) {
                $read = isset($reads[$key]) ? 1 : 0;
                $write = isset($writes[$key]) ? 1 : 0;
                $speak = isset($speaks[$key]) ? 1 : 0;
                $understand = isset($understands[$key]) ? 1 : 0;
    
                // Insert into language_proficiency table with the correct column name
                $language_sql = "INSERT INTO language_proficiency (user_id, language_p, read_l, write_l, speak_l, understand_l) VALUES (?, ?, ?, ?, ?, ?)";
                $language_stmt = $conn->prepare($language_sql);
                $language_stmt->bind_param("isiiii", $id, $language, $read, $write, $speak, $understand);
    
                if (!$language_stmt->execute()) {
                    echo "Error inserting language proficiency record for $language: " . $language_stmt->error . "<br>";
                }
                $language_stmt->close();
            }
        }
    }

    // Insert Work Experience
    if (!empty($_POST['company'])) {
        $companies = $_POST['company'] ?? [];
        $addresses = $_POST['address'] ?? [];
        $positions = $_POST['position'] ?? [];
        $start_dates = $_POST['start_date'] ?? [];
        $end_dates = $_POST['end_date'] ?? [];
        $statuses = $_POST['status'] ?? [];

        foreach ($companies as $key => $company) {
            if (!empty($company)) {
                $address = $addresses[$key] ?? '';
                $position = $positions[$key] ?? '';
                $start_date = $start_dates[$key] ?? '';
                $end_date = $end_dates[$key] ?? '';
                $status = $statuses[$key] ?? '';

                // Insert into work_exp table
                insertData($conn, 'work_exp', ['user_id', 'company_name', 'address', 'position', 'started_date', 'termination_date', 'status'], [$id, $company, $address, $position, $start_date, $end_date, $status], $id);
            }
        }
    }

    $conn->close();
    header("Location: ../../html/applicant/a_profile.php");
}
?>
