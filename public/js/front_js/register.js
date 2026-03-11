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

});
