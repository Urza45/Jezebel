$(function () {
    $("body").on("click", ".userinfo", function () {
        //$(".userinfo").on("click", function () {
        let userId = $(this).data("id");
        let urlDest = $(this).data("route");
        let newTitle = $(this).data("title");
        let newButton = $(this).data("button");
        let afficheButton = $(this).data("affiche");
        // AJAX request
        $.ajax({
            url: urlDest,
            type: "post",
            data: {
                userId: userId,
            },
            success: function (response) {
                // Add response in Modal body
                $(".modal-body").html(response);
                $(".modal-title").html(newTitle);
                $(".submitBtn").html(newButton);
                $(".submitBtn").show();
                if (afficheButton === "no") {
                    $(".submitBtn").hide();
                }
                // Display Modal
                $("#empModal").modal("show");
            },
            error: function () {
                $(".modal-body").html("Une erreur est survenue.");
                $(".modal-title").html("Erreur");
                $(".submitBtn").html(newButton);
                $(".submitBtn").show();
                if (afficheButton === "no") {
                    $(".submitBtn").hide();
                }
                // Display Modal
                $("#empModal").modal("show");
            }
        });
    });

    $("body").on("click", ".close", function () {
        //$(".close").on("click", function () {
        $("#empModal").modal("hide");
        location.reload(true);
    });

    $(".submitBtn").on("click", function () {
        let reg = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
        let name = $("#nameForm").val();
        let road = $("#route").val();
        let verif = true;
        let message = "";

        switch (name) {
            case "banUser":
                let activatedUser = $("input[name='ban_user[activatedUser]']:checked").val();
                if (activatedUser === "0") {
                    $(".statusMsg").html("Il vous faut choisir entre Oui ou Non.");
                    verif = false;
                }
                break;
            case "showUser":
                let pseudo = $("input[name='show_user[pseudo]'").val().trim();
                if ((pseudo.length > 10) || (pseudo.length < 5)) {
                    message = "L'identifiant doit être compris entre 5 et 10 caractères.";
                    verif = false;
                }
                let lastName = $("input[name='show_user[lastName]'").val().trim();
                if (lastName === "") {
                    if (message !== "") {
                        message = message + "<br/>";
                    }
                    message = message + "Vous devez saisir un nom.";
                    verif = false;
                }
                // let firstName = $("input[name='show_user[firstName]'").val();
                let email = $("input[name='show_user[email]'").val().trim();
                if (email === "") {
                    if (message !== "") {
                        message = message + "<br/>";
                    }
                    message = message + "Vous devez saisir un email.";
                    verif = false;
                }
                if ((email !== "") && (!reg.test(email))) {
                    if (message !== "") {
                        message = message + "<br/>";
                    }
                    message = message + "Vous devez saisir un email valide.";
                    verif = false;
                }
                // let phone = $("input[name='show_user[phone]'").val();
                // let cellPhone = $("input[name='show_user[cellPhone]'").val();
                let roles = $("#show_user_roles").val();
                if (roles.toString().trim() === "") {
                    if (message !== "") {
                        message = message + "<br/>";
                    }
                    message = message + "Vous devez choisir au moins un roles.";
                    verif = false;
                }
                // let slug = $("input[name='show_user[slug]'").val();
                // let createdAt = $("select[name='show_user[createdAt][day]'").val() + '/' + $("select[name='show_user[createdAt][month]'").val() + '/';
                // createdAt = createdAt + $("select[name='show_user[createdAt][year]'").val();
                // let isVerified = $("input[name='show_user[isVerified]']:checked").val();
                break;
            case "addPictureTrick":
                let legend = $("input[name='file_upload_trick[legend]'").val().trim();
                if (legend === "") {
                    if (message !== "") {
                        message = message + "<br/>";
                    }
                    message = message + "Vous devez saisir un nom de photo.";
                    verif = false;
                }
                let file = $("input[name='file_upload_trick[url]'").val().trim();
                if (file === "") {
                    if (message !== "") {
                        message = message + "<br/>";
                    }
                    message = message + "Vous devez choisir un fichier.";
                    verif = false;
                }
                break;
            default:
                verif = true;
        }

        if (verif === false) {
            $(".statusMsg").html("<p class=\"text-danger\">" + message + "</p>");
            return false;
        } else {
            let fd = new FormData($("form#formModal").get(0));

            $.ajax({
                type: "POST",
                url: road,
                contentType: false,
                processData: false,
                data: fd,//ici tu envois le formdata au serveur
                //data: $("form#formModal").serialize(),
                //data: new FormData($('form#formModal')),
                enctype: "multipart/form-data",
                beforeSend: function () {
                    $(".submitBtn").attr("disabled", "disabled");
                    $(".modal-body").css("opacity", ".5");
                },
                success: function (response) {
                    $(".statusMsg").html(response);
                    $(".submitBtn").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                },
                error: function () {
                    $(".statusMsg").html("<p class=\"text-danger\">Une erreur est survenue.</p>");
                    $(".submitBtn").removeAttr("disabled");
                    $(".modal-body").css("opacity", "");
                }
            });
        }
    });
})
