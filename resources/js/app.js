require("./bootstrap");

encryptionAES = (yourString) => {
    const key = CryptoJS.enc.Hex.parse(process.env.MIX_KEY_ENCRYPTION_LOGIN);
    const iv = CryptoJS.enc.Hex.parse(process.env.MIX_IV_ENCRYPTION_LOGIN);
    const ciphertext = CryptoJS.AES.encrypt(yourString, key, {
        iv: iv,
        padding: CryptoJS.pad.ZeroPadding,
    }).toString();

    return ciphertext;
};
