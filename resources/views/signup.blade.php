<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Registration</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, rgba(19, 84, 122, 0.8), rgba(58, 131, 181, 0.8)), url('https://source.unsplash.com/random/1600x900');
            background-size: cover;
            background-position: center;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }

        .container {
            backdrop-filter: blur(15px) saturate(180%);
            -webkit-backdrop-filter: blur(15px) saturate(180%);
            background-color: rgba(255, 255, 255, 0.25);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
            width: 800px;
            max-width: 90%;
            padding: 70px;
            text-align: center;
            animation: floatUp 1.5s ease-out forwards;
            opacity: 0;
        }

        @keyframes floatUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h1 {
            font-size: 32px;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: rgba(255, 255, 255, 0.8);
            text-align: left;
            font-weight: 500;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="tel"],
        textarea {
            width: 100%;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 12px;
            border: none;
            background: rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            color: white;
            backdrop-filter: blur(8px);
            transition: all 0.3s ease-in-out;
            font-size: 14px;
        }

        input:focus {
            border-color: #74b9ff;
            box-shadow: 0 0 8px rgba(116, 185, 255, 0.8);
            outline: none;
        }

        button {
            background: linear-gradient(135deg, #0984e3, #74b9ff);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 30px;
            cursor: pointer;
            font-size: 16px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
            margin: 10px 5px;
        }

        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 20px rgba(0, 0, 0, 0.2);
        }

        /* Glassmorphism Stepper */
        .stepper {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            position: relative;
            z-index: 2;
        }

        .stepper div {
            position: relative;
            width: 33%;
            padding: 15px;
            text-align: center;
            transition: all 0.3s ease-in-out;
            border-radius: 12px;
            color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }

        .stepper div.active {
            background-color: rgba(9, 132, 227, 0.3);
            box-shadow: 0 10px 30px rgba(9, 132, 227, 0.4);
        }

        .stepper div.completed {
            background-color: rgba(0, 184, 148, 0.5);
            color: white;
        }

        .stepper .icon {
            font-size: 26px;
            margin-bottom: 8px;
        }

        .stepper .step-label {
            font-size: 14px;
        }

        /* Floating moving objects for extra effect */
        @keyframes float {
            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0);
            }
        }

        .floating-object {
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(15px);
            border-radius: 50%;
            animation: float 5s ease-in-out infinite;
            z-index: 1;
        }

        .floating-object1 {
            top: 10%;
            left: 5%;
        }

        .floating-object2 {
            bottom: 15%;
            right: 10%;
        }

        .inline-inputs {
            display: flex;
            justify-content: space-between;
            gap: 5%;
        }

        .inline-inputs div {
            width: 48%;
        }

        /* Media Queries */
        @media (max-width: 768px) {
            .inline-inputs {
                flex-direction: column;
            }

            .inline-inputs div {
                width: 100%;
            }

            .container {
                width: 90%;
            }

            .stepper div {
                font-size: 12px;
            }

            input {
                font-size: 12px;
            }

            button {
                font-size: 14px;
            }
        }
            /* Upload Box Styles */
         /* Upload Box Styles */
         .upload-box {
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px dashed rgba(255, 255, 255, 0.6);
            padding: 20px;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            position: relative;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-top: 10px; /* Margin for spacing */
        }

        .upload-box:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .upload-box input[type="file"] {
            display: none;
        }

        .upload-box .icon {
            position: absolute;
            right: 20px;
            font-size: 24px;
            color: rgba(255, 255, 255, 0.7);
        }

        .upload-box .upload-text {
            font-size: 14px;
            text-align: center;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <div class="floating-object floating-object1"></div>
    <div class="floating-object floating-object2"></div>

    <div class="container">
        <h1>Employee Registration</h1>

        <!-- Glassmorphic Stepper -->
        <div class="stepper">
            <div id="step1" class="active">
                <i class="fas fa-user icon"></i>
                <span class="step-label">Personal Info</span>
            </div>
            <div id="step2">
                <i class="fas fa-address-book icon"></i>
                <span class="step-label">Emergency Contact</span>
            </div>
            <div id="step3">
                <i class="fas fa-info-circle icon"></i>
                <span class="step-label">Other Info</span>
            </div>
        </div>

        <form id="signupForm">
            <!-- Step 1: Personal Information (Part 1) -->
            <div class="step active" id="personalInfoPart1">
                <label for="fullName">Full Name:</label>
                <input type="text" id="fullName" name="fullName" placeholder="Enter your full name"  required oninput="this.value = this.value.replace(/[^a-zA-Z.,]/g, '');" required>

                <label for="address">Complete Permanent Address:</label>
                <input type="text" id="address" name="address" placeholder="Enter your permanent address" required>

                <div class="inline-inputs">
                    <div>
                        <label for="telephone">Telephone No.:</label>
                        <input type="tel" id="telephone" name="telephone" placeholder="Enter your telephone number" required oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                            required>
                    </div>
                    <div>
                        <label for="cellphone">Cell Phone No.:</label>
                        <input type="tel" id="cellphone" name="cellphone" placeholder="Enter your cell phone number" required oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                            required>
                    </div>
                </div>

                <div class="inline-inputs">
                    <div>
                        <label for="dob">Date of Birth:</label>
                        <input type="date" id="dob" name="dob" required>
                    </div>
                    <div>

                        <label for="email">Email Address:</label>
                        <input type="email" id="email" name="email"
                            placeholder="Enter your email Address" required>
                    </div>

                </div>

                <div class="inline-inputs">
                    <div>
                        <label for="nationality">Nationality:</label>
                        <input type="text" id="nationality" name="nationality" 
                            placeholder="Enter your nationality" required oninput="this.value = this.value.replace(/[^a-zA-Z]/g, '');"required>
                    </div>
                    <div>

                        <label for="religion">Religion:</label>
                        <input type="text" id="religion" name="religion"
                            placeholder="Enter your religion" required oninput="this.value = this.value.replace(/[^a-zA-Z]/g, '');"required>
                    </div>

                </div>

                <div class="inline-inputs">
                    <div>
                        <label for="fatherName">Father's Name:</label>
                        <input type="text" id="fatherName" name="fatherName" placeholder="Enter your father's name" required oninput="this.value = this.value.replace(/[^a-zA-Z.,]/g, '');"
                            required>
                    </div>
                    <div>
                        <label for="motherMaidenName">Mother's Maiden Name:</label>
                        <input type="text" id="motherMaidenName" name="motherMaidenName" placeholder="Enter your mother's maiden name" required oninput="this.value = this.value.replace(/[^a-zA-Z.,]/g, '');"
                            required>
                    </div>
                </div>

                <button type="button" id="nextToPart2">Next</button>
            </div>

            <!-- Step 1: Personal Information (Part 2) -->
            <div class="step" id="personalInfoPart2" style="display:none;">
                <div class="inline-inputs">
                    <div>
                        <label for="tin">Tin No.:</label>
                        <input type="text" id="tin" name="tin" placeholder="Enter your TIN number"
                            required>
                    </div>
                    <div>
                        <label for="sss">SSS No.:</label>
                        <input type="text" id="sss" name="sss" placeholder="Enter your SSS number"
                            required>
                    </div>
                </div>

                <div class="inline-inputs">
                    <div>
                        <label for="philHealth">PhilHealth No.:</label>
                        <input type="text" id="philHealth" name="philHealth"
                            placeholder="Enter your PhilHealth number" required>
                    </div>
                    <div>
                        <label for="hdmf">HDMF No.:</label>
                        <input type="text" id="hdmf" name="hdmf" placeholder="Enter your HDMF number"
                            required>
                    </div>
                </div>

                <button type="button" id="backToPart1">Back</button>
                <button type="button" id="nextToEmergencyContact">Next</button>
            </div>

            <!-- Step 2: Emergency Contact -->
            <div class="step" id="emergencyContact" style="display:none;">
                <label for="emergencyContactName">Emergency Contact Name:</label>
                <input type="text" id="emergencyContactName" name="emergencyContactName"
                    placeholder="Enter emergency contact name" required oninput="this.value = this.value.replace(/[^a-zA-Z.,]/g, '');" required>

                <label for="emergencyContactRelation">Relation:</label>
                <input type="text" id="emergencyContactRelation" name="emergencyContactRelation"
                    placeholder="Enter relation" required oninput="this.value = this.value.replace(/[^a-zA-Z]/g, '');" required>

                <label for="emergencyTelephoneNumber">Telephone No.:</label>
                <input type="tel" id="emergencyTelephoneNumber" name="emergencyTelephoneNumber"
                    placeholder="Enter telephone number" required oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                
                <label for="emergencyCellphoneNumber">Cellphone No.:</label>
                <input type="tel" id="emergencyCellphoneNumber" name="emergencyCellphoneNumber"
                    placeholder="Enter cellphone number" required oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>

                <button type="button" id="backToPersonalInfo">Back</button>
                <button type="button" id="nextToOtherInfo">Next</button>
            </div>

           <!-- Step 3: Other Info -->
<div class="step" id="otherInfo" style="display:none;">
    <div class="inline-inputs" style="display: flex; align-items: center; margin-bottom: 20px;">
        <div style="margin-right: 20px; flex-grow: 1;">
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required>
        </div>
        
        <div style="margin-right: 20px; flex-grow: 2;">
            <label for="signature">Signature (Upload or Draw)</label>
            <div class="upload-box">
                <input type="file" id="signature" name="signature" accept=".jpg, .jpeg, .png, .pdf, .docx">
                <span class="upload-text">Click or Drag to upload your signature</span>
                <i class="fas fa-upload icon"></i>
            </div>
        </div>
    </div>

    <div class="inline-inputs">
        <div>
            <label for="employeeNo">Employee No:</label>
            <input type="text" id="employeeNo" name="employeeNo" placeholder="Enter employee number" required>
        </div>
        <div>
            <label for="startDate">Start Date:</label>
            <input type="date" id="startDate" name="startDate" required>
        </div>
    </div>

    <button type="button" id="backToEmergencyContact">Back</button>
    <button type="submit">Submit</button>
</div>

            
        </form>
    </div>

    <script>
        const nextToPart2 = document.getElementById('nextToPart2');
        const backToPart1 = document.getElementById('backToPart1');
        const nextToEmergencyContact = document.getElementById('nextToEmergencyContact');
        const backToPersonalInfo = document.getElementById('backToPersonalInfo');
        const nextToOtherInfo = document.getElementById('nextToOtherInfo');
        const backToEmergencyContact = document.getElementById('backToEmergencyContact');

        const personalInfoPart1 = document.getElementById('personalInfoPart1');
        const personalInfoPart2 = document.getElementById('personalInfoPart2');
        const emergencyContact = document.getElementById('emergencyContact');
        const otherInfo = document.getElementById('otherInfo');

        nextToPart2.addEventListener('click', () => {
            personalInfoPart1.style.display = 'none';
            personalInfoPart2.style.display = 'block';
            document.getElementById('step1').classList.remove('active');
            document.getElementById('step1').classList.add('completed');
            document.getElementById('step2').classList.add('active');
        });

        backToPart1.addEventListener('click', () => {
            personalInfoPart1.style.display = 'block';
            personalInfoPart2.style.display = 'none';
            document.getElementById('step1').classList.remove('completed');
            document.getElementById('step2').classList.remove('active');
        });

        nextToEmergencyContact.addEventListener('click', () => {
            personalInfoPart2.style.display = 'none';
            emergencyContact.style.display = 'block';
            document.getElementById('step2').classList.add('completed');
            document.getElementById('step3').classList.add('active');
        });

        backToPersonalInfo.addEventListener('click', () => {
            emergencyContact.style.display = 'none';
            personalInfoPart2.style.display = 'block';
            document.getElementById('step2').classList.remove('completed');
            document.getElementById('step1').classList.add('active');
        });

        nextToOtherInfo.addEventListener('click', () => {
            emergencyContact.style.display = 'none';
            otherInfo.style.display = 'block';
            document.getElementById('step3').classList.add('active');
        });

        backToEmergencyContact.addEventListener('click', () => {
            otherInfo.style.display = 'none';
            emergencyContact.style.display = 'block';
            document.getElementById('step3').classList.remove('active');
        });
    </script>
</body>

</html>
