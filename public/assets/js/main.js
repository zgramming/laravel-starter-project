function replaceAll(Source, stringToFind, stringToReplace) {
    let temp = Source;
    if (temp === undefined) return null;
	if(temp === 0 || temp === "") return null;
    let index = temp.indexOf(stringToFind);
    while (index !== -1) {
        temp = temp.replace(stringToFind, stringToReplace);
        index = temp.indexOf(stringToFind);
    }
    return temp;
}


function fromCurrency(val) {
    let result;
    result = replaceAll(val, ",", "");
	if(isNaN(result) || result === "") return 0;
	return parseFloat(result);
}

function formatCurrency(val,decimal = 4) {

    x = val.split(".");
    num = x[0];

    if (num < 0) return "";
    num = num.toString().replace(/\$|\,/g, '');
    if (isNaN(num))
        num = "0";
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num * 100 + 0.50000000001);
    cents = num % 100;
    num = Math.floor(num / 100).toString();
    if (cents < 10)
        cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
        num = num.substring(0, num.length - (4 * i + 3)) + ',' +
            num.substring(num.length - (4 * i + 3));

    if (x.length == 1)
        return (((sign) ? '' : '-') + num);
    else
        return (((sign) ? '' : '-') + num + "." + x[1].substr(0, decimal));
}

function toCurrency(elem,decimal = 4) {

    let replace = formatCurrency(elem.value.replace(/[\\A-Za-z!"?$%^&*+_={}; ()\-\:'/@#~,?\<>?|`?\]\[]/g, ''), decimal);
    if (replace.length === 0) replace = 0;
    elem.value = replace;
}
