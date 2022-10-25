const stringToHex = (string) => CryptoJS.enc.Hex.parse(string);
window.exampleEncrypt = function (yourString, key, iv) {
    const ciphertext = CryptoJS.AES.encrypt(
        yourString,
        stringToHex(process.env.MIX_ENCRYPTION_KEY),
        {
            iv: stringToHex(process.env.MIX_ENCRYPTION_IV),
            padding: CryptoJS.pad.ZeroPadding,
        }
    ).toString();

    return ciphertext;
};

function exampleDencrypt(yourString, key, iv) {
    const ciphertext = CryptoJS.AES.decrypt(yourString, stringToHex(key), {
        iv: stringToHex(iv),
    }).toString(CryptoJS.enc.Utf8);

    return ciphertext;
}
