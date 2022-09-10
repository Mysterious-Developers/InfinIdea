const LikeMachine = new XMLHttpRequest();
const LikeRefresher = new XMLHttpRequest();
aid = 0;
function performLike( id ) {
    aid = id;
    const url = "https://myproject.mysteriousdev.fr/article.php?id=" + id + "&action=like";
    console.log("[INFO] Sending like request to " + url);
    LikeMachine.open("GET", url);
    LikeMachine.send();


}

LikeMachine.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        // we get the response
        const response = this.responseText;
        console.log("[INFO] Like request response: " + response);
        // we refresh the like counter
        refreshLikeCounter();
    }
}

function refreshLikeCounter( id ) {
    const url = "https://myproject.mysteriousdev.fr/tools/infos.php?like=" + aid;
    console.log("[INFO] Refreshing like counter");
    LikeRefresher.open("GET", url);
    LikeRefresher.send();
}

// when the request is done, refresh the like counter
LikeRefresher.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
        // we get the response
        const response = this.responseText;
        console.log("[INFO] Like request response: " + response);
        // we set the paragraph with the id likeCounter to the response
        document.getElementById("likeCounter").innerHTML = response;
    }
}


