export const isImage = (attachment) => {
    const mime = attachment.mime || attachment.type
    return mime.split('/')[0].toLowerCase() === 'image'
}