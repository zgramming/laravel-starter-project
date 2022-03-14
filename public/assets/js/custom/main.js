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

function IsJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}


function hideErrorsOnModal(){
    $(".modal-container-error").remove();
}

function showErrorsOnModal(errors){
    console.log('Errors occured on modal : ',errors);
    $(".modal-container-error").remove();
    $(".modal-header-custom").append(`
                <div class="d-flex flex-row flex-fill modal-container-error mt-3">
                    <div class="alert alert-danger alert-dismissible show fade w-100">
                        <div class="modal-container-item"></div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
                `);

    /// If errors is object || array, we should iterate it
    if(typeof errors === "object" || Array.isArray(errors)){
        $.each(errors, (key, value) => {
            $(".modal-container-item").append(`<ul><li>${value}</li></ul>`);
        });
    }else{
        $(".modal-container-item").append(`<ul><li>${errors}</li></ul>`);
    }
}
// [https://stackoverflow.com/questions/28948383/how-to-implement-debounce-fn-into-jquery-keyup-event
// [http://davidwalsh.name/javascript-debounce-function]
function debounce(func, wait, immediate) {
    let timeout;
    return function() {
        const context = this, args = arguments;
        const later = function () {
            timeout = null;
            if (!immediate) func.apply(context, args);
        };
        const callNow = immediate && !timeout;
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
        if (callNow) func.apply(context, args);
    };
}
