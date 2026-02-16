function ZipCodeValidator(){

}

ZipCodeValidator.prototype.validateZipCode = function(idList){
    idList.homeAddressZip && validateZipOnInput(idList.homeAddressZip);
    idList.mailingAddressZip && validateZipOnInput(idList.mailingAddressZip);
    idList.previousAddressZip && validateZipOnInput(idList.previousAddressZip);
    idList.homeAddressZipJt && validateZipOnInput(idList.homeAddressZipJt);
    idList.mailingAddressZipJt && validateZipOnInput(idList.mailingAddressZipJt);
    idList.previousAddressZipJt && validateZipOnInput(idList.previousAddressZipJt);
    idList.billingAddressZip && validateZipOnInput(idList.billingAddressZip);
}

function getUpdatedZipCode(zip){
    var actualZip = zip;
    var isValidZip = /^[0-9\\-]+$/.test(actualZip);
    if(!isValidZip){
        actualZip = actualZip.replace(/.$/,'');			
    }
    if((actualZip.indexOf('-')>-1) && ((actualZip.indexOf('-')!==5) || (actualZip.match(/-/g).length>1)) && (actualZip.length>6)){
        actualZip = actualZip.split('-').join('');
        actualZip = actualZip.substr(0,5)+'-'+actualZip.substr(5,actualZip.length);
    }
    if((actualZip.indexOf('-')>-1) && (actualZip.length<6)){
        actualZip = actualZip.replace(/-/g,'');
    }
    if(actualZip.length>5){
        if(actualZip.indexOf('-')===-1){				
            actualZip = actualZip.substr(0,5)+'-'+actualZip.substr(5,actualZip.length);
        } else if((actualZip.length===6) && (actualZip.indexOf('-')>-1)) {				
            actualZip = actualZip.replace(/-/g,'');				
        }
    }
    return actualZip;
}

function validateZipOnInput(zipId, hiddenZipId){    
    $('#'+ zipId).on('input', function(e){
        var actualZip = getUpdatedZipCode(e.target.value);
        $('#'+ zipId).val(actualZip);       
    });
}