async function encryptData(data, keyStr) {
    const key = new TextEncoder().encode(keyStr);
    const iv = crypto.getRandomValues(new Uint8Array(16));

    const cryptoKey = await crypto.subtle.importKey(
        "raw",
        key,
        { name: "AES-CBC" },
        false,
        ["encrypt"]
    );

    const encryptedData = await crypto.subtle.encrypt(
        { name: "AES-CBC", iv: iv },
        cryptoKey,
        new TextEncoder().encode(data)
    );

    const ivHex = Array.from(iv).map(b => b.toString(16).padStart(2, '0')).join('');
    const encryptedHex = Array.from(new Uint8Array(encryptedData)).map(b => b.toString(16).padStart(2, '0')).join('');

    return btoa(ivHex + encryptedHex);
}

async function decryptData(encryptedData, keyStr) {
    const decodeBase64 = atob(encryptedData);
    const key = new TextEncoder().encode(keyStr);
    const iv = new Uint8Array(decodeBase64.slice(0, 32).match(/.{1,2}/g).map(byte => parseInt(byte, 16)));
    const encryptedArray = new Uint8Array(decodeBase64.slice(32).match(/.{1,2}/g).map(byte => parseInt(byte, 16)));

    const cryptoKey = await crypto.subtle.importKey(
        "raw",
        key,
        { name: "AES-CBC" },
        false,
        ["decrypt"]
    );

    const decryptedData = await crypto.subtle.decrypt(
        { name: "AES-CBC", iv: iv },
        cryptoKey,
        encryptedArray
    );

    return new TextDecoder().decode(decryptedData);
}

const url = window.location.origin;

function customText(length) {
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let result = '';
    const charactersLength = characters.length;
    
    for (let i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    
    return result;
}