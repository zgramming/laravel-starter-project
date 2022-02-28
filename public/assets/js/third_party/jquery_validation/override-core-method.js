/// Override core function when number is format currency
/// We should convert it to valid number firstly
$.validator.methods.min = function(value,element,param){
    let convert = fromCurrency(value);
    return this.optional( element ) || convert >= param;
}

/// Override core function when number is format currency
/// We should convert it to valid number firstly
$.validator.methods.max = function(value,element,param){
    let convert = fromCurrency(value);
    return this.optional( element ) || convert <= param;
}

/// Override core function when number is format currency
/// We should convert it to valid number firstly
$.validator.methods.range = function(value,element,param){
    let convert = fromCurrency(value);
    return this.optional( element ) || ( convert >= param[ 0 ] && convert <= param[ 1 ] );
}

