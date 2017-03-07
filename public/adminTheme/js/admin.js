/**
 * Get xml instance
 * @returns {boolean}
 */
function getXmlInstance() {
    var xmlHttp = false;

    if (window.ActiveXObject) {
        try {
            xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (e) {
            xmlHttp = false;
        }
    } else {
        try {
            xmlHttp = new XMLHttpRequest();
        } catch (e) {
            xmlHttp = false;
        }
    }

    return xmlHttp;
}

/**
 * Check for xml ready state and status
 * @param xmlHttp
 * @returns {boolean}
 */
function isXmlReady(xmlHttp) {
    return xmlHttp.readyState == 4 && xmlHttp.status == 200;
}

function getProfessorDetails(id){
    //creating xmlHttpRequest object
    var xmlHttp = getXmlInstance();

    if (!xmlHttp) {
        alert("Error. Cant create xml object!");
    }
    //--end

    if (xmlHttp) {
        xmlHttp.open("GET", "getProfessorDetails/" + id, true);
        xmlHttp.onreadystatechange = function () {
            if (isXmlReady(xmlHttp)) {
                document.getElementById("CourseDetails").innerHTML = this.responseText;
                $('.loading-div').hide();
                delete xmlHttp;
                xmlHttp = null;
            }
        };
        xmlHttp.send(null);
    }

    return false;
}