var dialogContent = ( (settings.imageUpload) ? "<form action=\"" + action + "\" target=\"" + iframeName + "\" method=\"post\" enctype=\"multipart/form-data\" class=\"" + classPrefix + "form\">" : "<div class=\"" + classPrefix + "form\">" ) +
    ( (settings.imageUpload) ? "<iframe name=\"" + iframeName + "\" id=\"" + iframeName + "\" guid=\"" + guid + "\"></iframe>" : "" ) +
    "<label>" + imageLang.url + "</label>" +
    "<input type=\"text\" data-url />" + (function () {
        return (settings.imageUpload) ? "<div class=\"" + classPrefix + "file-input\">" +
            "<input type=\"file\" name=\"" + classPrefix + "image-file\" accept=\"image/*\" />" +
            csrfField +
            "<input type=\"submit\" value=\"" + imageLang.uploadButton + "\" />" +
            "</div>" : "";
    })() +
    "<br/>" +
    "<label>" + imageLang.alt + "</label>" +
    "<input type=\"text\" value=\"" + selection + "\" data-alt />" +
    "<br/>" +
    "<label>" + imageLang.link + "</label>" +
    "<input type=\"text\" value=\"http://\" data-link />" +
    "<br/>" + csrfField +
    ( (settings.imageUpload) ? "</form>" : "</div>");

