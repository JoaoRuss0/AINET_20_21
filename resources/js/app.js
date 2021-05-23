require('./bootstrap');

var clear_buttons = document.querySelectorAll(".clear_button");

clear_buttons.forEach(button =>
    {
        button.addEventListener("click", function()
        {
            document.querySelectorAll(".filter input[type='text']").forEach(element =>
                {
                    element.setAttribute('value', "");
                }
            );

            document.querySelectorAll(".filter select option").forEach(element =>
                {
                    element.removeAttribute('selected');
                }
            );
        })
    }
)

var payment_ref_element = document.getElementById("client_payment_ref");
var payment_type_element = document.getElementById("client_payment_type");
var user_email_element = document.getElementById("user_email");

// Payment reference field starts as disabled and without a pattern
// If the form has invalid values filled in, after submitting, laravel redirects back to the register page and the payment type is automatically selected
// which has to have a pattern and not be disabled if it is either "VISA" or "MC"
if(payment_ref_element && payment_type_element && user_email_element)
{
    if(payment_type_element.value == "MC" || payment_type_element.value == "VISA")
    {
        payment_ref_element.removeAttribute('disabled');
        payment_ref_element.setAttribute('pattern', "^\\d{16}$");
    }

    // Anytime the email changes, if the payment type is paypal, the payment reference has to also change
    user_email_element.addEventListener("change", function(e)
        {
            if(payment_type_element.value == "PAYPAL")
            {
                payment_ref_element.value = this.value;
            }
        }
    )

    // When NONE or "PAYPAL" are selected, field should be disabled
    // When "VISA" or "MC" are selected, field shouldn't be disabled and pattern must be 16 digits
    payment_type_element.addEventListener("change", function(e)
        {
            if(this.value == "VISA" || this.value == "MC")
            {
                payment_ref_element.value = "";
                payment_ref_element.removeAttribute('disabled');
                payment_ref_element.setAttribute('pattern', "^\\d{16}$");
            }
            else
            {
                payment_ref_element.setAttribute('disabled',"");
                payment_ref_element.removeAttribute('pattern');

                if(this.value == "")
                {
                    payment_ref_element.value = "";
                }
                else
                {
                    payment_ref_element.value = user_email_element.value;
                }
            }
        }
    )
}

var logout_href = document.getElementById("logout_href");

if(logout_href)
{
    logout_href.addEventListener("click", function(e)
        {
            e.preventDefault();
            document.getElementById('logout-form').submit();
        }
    )
}

var user_menu_href = document.getElementById("user_menu_href");

if(user_menu_href)
{
    user_menu_href.addEventListener("click", function(e)
        {
            e.preventDefault();
            document.getElementById("menu_dropdown_items").classList.toggle("invisible");

            var svg_path = this.querySelectorAll(".menu_dropdown_arrow path")[0]
            var value = svg_path.getAttribute("d")

            if(value.split(' ')[1] == "7.33l2.829-2.83")
            {
                svg_path.setAttribute("d", "M0 16.67l2.829 2.83 9.175-9.339 9.167 9.339 2.829-2.83-11.996-12.17z")
            }
            else
            {
                svg_path.setAttribute("d", "M0 7.33l2.829-2.83 9.175 9.339 9.167-9.339 2.829 2.83-11.996 12.17z")
            }

        }
    )
}

