const stringToHex = (string) => CryptoJS.enc.Hex.parse(string);
function exampleEncrypt(yourString, key, iv) {
    const ciphertext = CryptoJS.AES.encrypt(yourString, stringToHex(key), {
        iv: stringToHex(iv),
        padding: CryptoJS.pad.ZeroPadding,
    }).toString();

    return ciphertext;
}

function exampleDencrypt(yourString, key, iv) {
    const ciphertext = CryptoJS.AES.decrypt(yourString, stringToHex(key), {
        iv: stringToHex(iv),
    }).toString(CryptoJS.enc.Utf8);

    return ciphertext;
}
