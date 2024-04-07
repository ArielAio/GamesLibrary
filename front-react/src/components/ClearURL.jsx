const cleanURL = (url) => {
    // Remove espaços em branco
    const noSpaces = url.replace(/\s/g, '%20');
    // Remove outros caracteres especiais duplicados
    const cleanedURL = decodeURIComponent(noSpaces);
    return cleanedURL;
}

export default cleanURL;
