$(document).ready(function () {  
    $('#password').keyup(function () {  
        $('#strengthMessage').html(checkStrength($('#password').val()));
        var confirmPassword = $("#password_confirmation").val();
        if(confirmPassword.length > 0){
            checkConfirmation();
        }
    })
    $('#password_confirmation').keyup(function () {  
        checkConfirmation();
    })
    function checkConfirmation() { 
        var password = $("#password").val();
        var confirmPassword = $("#password_confirmation").val();
        if (password != confirmPassword){
            $("#passwordMessage").html("As senhas não são iguais!");
            $('#passwordMessage').removeClass();
            $('#passwordMessage').addClass('Invalida');
        }
        else{
            if (password.length > 7) {  
                $("#passwordMessage").html("Tudo ok!");
                $('#passwordMessage').removeClass();
                $('#passwordMessage').addClass('Valida');
            }else{
                $("#passwordMessage").html(" ");
                $('#passwordMessage').removeClass();
            }
        }
    };

    function checkStrength(password) {  
        var strength = 0  
        if (password.length < 8) {  
            $('#strengthMessage').removeClass()  
            $('#strengthMessage').addClass('Short')  
            return 'Muito curta'  
        }  
        if (password.length > 7) strength += 1  
        // If password contains both lower and uppercase characters, increase strength value.  
        if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1  
        // If it has numbers and characters, increase strength value.  
        if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1  
        // If it has one special character, increase strength value.  
        if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1  
        // If it has two special characters, increase strength value.  
        if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1  
        // Calculated strength value, we can return messages  
        // If value is less than 2  
        if (strength < 2) {  
            $('#strengthMessage').removeClass()  
            $('#strengthMessage').addClass('Weak')  
            return 'Fraca'  
        } else if (strength == 2) {  
            $('#strengthMessage').removeClass()  
            $('#strengthMessage').addClass('Good')  
            return 'Boa'  
        } else {  
            $('#strengthMessage').removeClass()  
            $('#strengthMessage').addClass('Strong')  
            return 'Forte'  
        }  
    }  
});