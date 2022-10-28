const button = document.getElementById('submit');

const viewMore = document.getElementById('viewMore');
viewMore.addEventListener('click', () => {
    alert('View More');
});

button.addEventListener("click", function () {
    button.enabled = false;

    const title = document.getElementsByClassName("title")[0].value
    const description = document.getElementsByClassName("description")[0].value
    const content = document.getElementsByClassName("content")[0].value
    const tags = document.getElementsByClassName("tags")[0].value

    const title_regex = /^.{4,50}$/
    const description_regex = /^.{4,200}$/
    const content_regex = /^[\s\S]{30,10000}$/
    const tags_regex = /^.{0,1000}$/

    let legit = true;

    if (!title_regex.test(title)) {
        document.getElementsByClassName("title-error")[0].style.display = "block"
        legit = false;
    } else {
        document.getElementsByClassName("title-error")[0].style.display = "none"
    }
    if (!description_regex.test(description)) {
        document.getElementsByClassName("description-error")[0].style.display = "block"
        legit = false;
    } else {
        document.getElementsByClassName("description-error")[0].style.display = "none"
    }
    if (!content_regex.test(content)) {
        document.getElementsByClassName("content-error")[0].style.display = "block"
        legit = false;
    } else {
        document.getElementsByClassName("content-error")[0].style.display = "none"
    }
    if (!tags_regex.test(tags)) {
        document.getElementsByClassName("tags-error")[0].style.display = "block"
        legit = false;
    } else {
        document.getElementsByClassName("tags-error")[0].style.display = "none"
    }

    if (legit) {
        jQuery.ajax({
            url: '/backend/php/publish-article.php',
            type: 'POST',
            data: {
                title: title,
                description: description,
                content: content,
                tags: tags
            },
            success: function (data) {
                code = data;
                if (code.startsWith("https://")) {
                    const success = document.getElementsByClassName("success")[0]
                    const link = document.getElementsByClassName("link-article")[0]
                    button.style.color = "green"
                    button.innerHTML = "Publié"
                    button.enabled = false;
                    success.style.display = "block"
                    link.href = code
                } else {
                    switch (code) {
                        case "2":
                            alert("Erreur lors de la publication de l'article")
                            break;
                        case "3":
                            alert("Les données envoyées n\'ont pas pu être associées à un article")
                            break;
                        case "1":
                            alert("Les données envoyées ne sont pas valides")
                            break;
                        case "4":
                            alert("Un article avec le même titre existe déjà")
                            break;

                        default:
                            alert("Erreur inconnue")
                            break;

                    }
                }

            },
            error: function () {
                alert("Erreur durant la publication de l'article")
                button.style.backgroundColor = "red"
                button.enabled = true;
            }
        })
        return true;

    } else {
        return false;
    }


});

