function PostalAddressVerification(){

}

PostalAddressVerification.prototype.validateAddress = function(idList, isOpenModal, recommendedData){
    var street1 = $('#'+idList.street1).val(),
        street2 = $('#'+idList.street2).val(),
        city = $('#'+idList.city).val(),
        state = $('#'+idList.state).val(),
        zip = $('#'+idList.zip).val();
    $('#recommended-address-field, #user-address').removeAttr('aria-required');
    $('.hidden-address-validator').find('.ui-hidden-accessible').text('');
    if (zip && (zip !=='') && isOpenModal) {
        var userAddressSelection = 'recommended';
        $('#'+idList.recommendedAddress).append(frameAddressInPopup(recommendedData.street1, recommendedData.street2, recommendedData.city, recommendedData.state, recommendedData.zip));
        $('#'+idList.userTypedAddress).append(frameAddressInPopup(street1, street2, city, state, zip));
        $('#'+idList.addressValidator).trigger('click');

        $('input:radio[name=addressVerificationApplicationChoice]').change(function(){
			if(this.value === 'userEnteredAddress') {
				userAddressSelection = 'userEnteredAddress';
			} else if(this.value === 'recommended') {
                userAddressSelection = 'recommended';
            }
        });        
        
        $('#'+idList.saveButton).click(function(e){           
			if(userAddressSelection === 'recommended'){  
				$('#'+idList.street1).val(recommendedData.street1);
				$('#'+idList.street2).val(recommendedData.street2);
				$('#'+idList.city).val(recommendedData.city);
				$('#'+idList.state).val(recommendedData.state);
				$('#'+idList.zip).val(recommendedData.zip);
			}
            $('#'+idList.street1 + ', #'+idList.street2 + ', #'+idList.street2 + ', #'+idList.city + ', #'+idList.state + ', #'+idList.zip).attr('aria-live', 'polite');
                        
            var scrollTo = $('#'+idList.street1).offset().top;

            if (scrollTo > 100) {
                scrollTo -= 100;
            }

            $('html, body').animate({
                scrollTop : scrollTo
            }, 400, function() {
                setTimeout(function(){
                    $('#'+idList.street1).focus()                    
                },0);                
            });
		})
    }    
}

function frameAddressInPopup(street1, street2, city, state, zip){
    var addressString = '<p>'+street1+'</p><p>'+street2+'</p><p><span>'+city+',</span><span> '+state+'</span></p><p>'+zip+'</p>';
    return addressString;
}