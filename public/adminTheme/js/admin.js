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

function editProfessorDetails(id){
    //creating xmlHttpRequest object
    var xmlHttp = getXmlInstance();

    if (!xmlHttp) {
        alert("Error. Cant create xml object!");
    }
    //--end

    if (xmlHttp) {
        xmlHttp.open("GET", "professors/" + id + "/edit", true);
        xmlHttp.onreadystatechange = function () {
            if (isXmlReady(xmlHttp)) {
                document.getElementById("editProfessorWrapper").innerHTML = this.responseText;
                $('#editProfessorWrapper').ready(function() {
                    $('#editProfessorModal').modal();
                });
                delete xmlHttp;
                xmlHttp = null;
            }

        };
        xmlHttp.send(null);
    }

    return false;
}

function editOrganizationDetails(id){
    //creating xmlHttpRequest object
    var xmlHttp = getXmlInstance();

    if (!xmlHttp) {
        alert("Error. Cant create xml object!");
    }
    //--end

    if (xmlHttp) {
        xmlHttp.open("GET", "organizations/" + id + "/edit", true);

        xmlHttp.onreadystatechange = function () {
            if (isXmlReady(xmlHttp)) {
                document.getElementById("editOrgWrapper").innerHTML = this.responseText;
                $('#editOrgWrapper').ready(function() {
                    $('#editOrgModal').modal();
                });
                delete xmlHttp;
                xmlHttp = null;
            }

        };
        xmlHttp.send(null);
    }

    return false;
}

function editSectionDetails(id){
    //creating xmlHttpRequest object
    var xmlHttp = getXmlInstance();

    if (!xmlHttp) {
        alert("Error. Cant create xml object!");
    }
    //--end

    if (xmlHttp) {
        xmlHttp.open("GET", "/sections/" + id + "/edit", true);

        xmlHttp.onreadystatechange = function () {
            if (isXmlReady(xmlHttp)) {
                document.getElementById("editSectionWrapper").innerHTML = this.responseText;
                $('#editSectionWrapper').ready(function() {
                    $('#editSectionModal').modal();
                });
                delete xmlHttp;
                xmlHttp = null;
            }

        };
        xmlHttp.send(null);
    }

    return false;
}

$('.form-delete').submit(function() {
    return confirm('Are you sure to delete record?');
});