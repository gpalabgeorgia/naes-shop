$(window).on("load", function(){

    $("#registerForm").validate({
        rules: {
            name: "required",
            mobile: {
                required: true,
                minlength: 9,
                maxlength: 14,
                digits: true
            },
            email: {
                required: true,
                email: true,
                remote: "check-email"
            },
            password: {
                required: true,
                minlength: 6
            }
        },
        messages: {
            name: "გთხოვთ შეიყვანოთ სახელი / გვარი",
            mobile: {
                required: "გთხოვთ შეიყვანოთ ტელ. ნომერი",
                minlength: "ტელეფონის ნომერი დაუშვებელია 9 რიცხვზე ნაკლები",
                maxlength: "ტელეფონის ნომერი დაუშვებელია 14 რიცხვზე მეტი",
                digits: "გთხოვთ შეიყვანოთ ვალიდური ტელეფონის ნომერი"
            },
            email: {
                required: "გთხოვთ შეიყვანოთ თქვენი ელ.ფოსტის მისამართი",
                email: "გთხოვთ შეიყვანოთ ვალიდური ელ.ფოსტის მისამართი",
                remote: "ელ.ფოსტა უკვე დარეგისტრირებულია"
            },
            password: {
                required: "გთხოვთ შეიყვანოთ პაროლი",
                minlength: "პაროლი უნდა შედგებოდეს მინიმუმ 6 სიმბოლოსგან"
            }
        }
    });

    $("#accountForm").validate({
        rules: {
            name: {
                required: true,
                accept: "[a-zA-Z]+"
            },
            mobile: {
                required: true,
                minlength: 9,
                maxlength: 14,
                digits: true
            },
        },
        messages: {
            name: {
                required: "გთხოვთ შეიყვანოთ სახელი / გვარი",
                accept: "გთხოვთ შეიყვანოთ ვალიდური სახელი / გვარი"
            },
            mobile: {
                minlength: "ტელეფონის ნომერი დაუშვებელია 9 რიცხვზე ნაკლები",
                maxlength: "ტელეფონის ნომერი დაუშვებელია 14 რიცხვზე მეტი",
                digits: "გთხოვთ შეიყვანოთ ვალიდური ტელეფონის ნომერი"
            },
        }
    });

    $("#loginForm").validate({
        rules: {
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 6
            }
        },
        messages: {
            email: {
                required: "გთხოვთ შეიყვანოთ თქვენი ელ.ფოსტის მისამართი",
                email: "გთხოვთ შეიყვანოთ ვალიდური ელ.ფოსტის მისამართი",
            },
            password: {
                required: "გთხოვთ შეიყვანოთ თქვენი პაროლი",
                minlength: "პაროლი უნდა შედგებოდეს მინიმუმ 6 სიმბოლოსგან"
            }
        }
    });

    $("#current_pwd").keyup(function() {
        let current_pwd = $(this).val();
        $.ajax({
            type: 'post',
            url: 'check-user-pwd',
            data: {current_pwd:current_pwd},
            success: function(resp) {
                // alert(resp);
                if(resp==false) {
                    $("#chkPwd").html("<font color='red'>მიმდინარე პაროლი არასწორია</font>");
                }else if(resp==true) {
                    $("#chkPwd").html("<font color='green'>მიმდინარე პაროლი სწორია</font>");
                }
            },error:function() {
                alert("წარმოიშვა შეცდომა");
            }
        });
    });

    $("#passwordForm").validate({
        rules: {
            current_pwd: {
                required: true,
                minlength: 6,
                maxlength: 20
            },
            new_pwd: {
                required: true,
                minlength: 6,
                maxlength: 20
            },
            confirm_pwd: {
                required: true,
                minlength: 6,
                maxlength: 20,
                equalTo: "#new_pwd"
            }
        },
        messages: {
            name: {
                required: "გთხოვთ შეიყვანოთ სახელი / გვარი",
                accept: "გთხოვთ შეიყვანოთ ვალიდური სახელი / გვარი"
            },
            mobile: {
                minlength: "ტელეფონის ნომერი დაუშვებელია 9 რიცხვზე ნაკლები",
                maxlength: "ტელეფონის ნომერი დაუშვებელია 14 რიცხვზე მეტი",
                digits: "გთხოვთ შეიყვანოთ ვალიდური ტელეფონის ნომერი"
            },
        }
    });
});
