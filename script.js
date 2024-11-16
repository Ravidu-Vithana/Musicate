const { Modal } = require("./bootstrap");

function signUp() {
    var fname = document.getElementById("f");
    var lname = document.getElementById("l");
    var dob = document.getElementById("dob");
    var gender = document.getElementById("g");
    var email = document.getElementById("e");
    var password = document.getElementById("p");
    var mobile = document.getElementById("m");

    document.getElementById("errf").innerHTML = "";
    document.getElementById("errl").innerHTML = "";
    document.getElementById("errdob").innerHTML = "";
    document.getElementById("errg").innerHTML = "";
    document.getElementById("erre").innerHTML = "";
    document.getElementById("errp").innerHTML = "";
    document.getElementById("errm").innerHTML = "";
    document.getElementById("erra").innerHTML = "";

    var agreed;

    if (document.getElementById("agreebox").checked) {
        agreed = 1;
    } else {
        agreed = 0;
    }

    var f = new FormData();

    f.append("f", fname.value);
    f.append("l", lname.value);
    f.append("dob", dob.value);
    f.append("g", gender.value);
    f.append("e", email.value);
    f.append("p", password.value);
    f.append("m", mobile.value);
    f.append("a", agreed);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "emptyf") {
                document.getElementById("errf").innerHTML = "First Name Cannot Be Empty!!!";
            } else if (t == "longf") {
                document.getElementById("errf").innerHTML = "First Name must have less than 20 characters!";
            } else if (t == "emptyl") {
                document.getElementById("errl").innerHTML = "Last Name Cannot Be Empty!!!";
            } else if (t == "longl") {
                document.getElementById("errl").innerHTML = "Last name must have less than 30 characters!";
            } else if (t == "emptydob") {
                document.getElementById("errdob").innerHTML = "Please select your Date of Birth";
            } else if (t == "notselectedg") {
                document.getElementById("errg").innerHTML = "Please select your gender";
            } else if (t == "emptye") {
                document.getElementById("erre").innerHTML = "Please enter your email";
            } else if (t == "longe") {
                document.getElementById("erre").innerHTML = "Email must have less than 100 characters";
            } else if (t == "invalide") {
                document.getElementById("erre").innerHTML = "Invalid email!!!";
            } else if (t == "emptyp") {
                document.getElementById("errp").innerHTML = "Password cannot be empty";
            } else if (t == "strlenp") {
                document.getElementById("errp").innerHTML = "Password must have 5 - 20 characters";
            } else if (t == "emptym") {
                document.getElementById("errm").innerHTML = "Please enter your mobile number";
            } else if (t == "invalidm") {
                document.getElementById("errm").innerHTML = "Invalid mobile!!!";
            } else if (t == "notaccepted") {
                document.getElementById("erra").innerHTML = "You must accept the Terms and Conditions!";
            } else if (t == "userexist") {
                document.getElementById("erru").innerHTML = "User with this email or mobile already exists!!";
            } else if (t == "success") {
                fname.value = "";
                lname.value = "";
                dob.value = "";
                email.value = "";
                password.value = "";
                mobile.value = "";

                alert("Sign Up Successfull!");
                window.location = "signIn.php";
            } else {
                alert(t);
            }
        }
    };

    r.open("POST", "signUpProcess.php", true);
    r.send(f);

}

function signIn() {
    var email = document.getElementById("e");
    var password = document.getElementById("p");
    var r;

    if (document.getElementById("r").checked) {
        r = 1;
    } else {
        r = 0;
    }

    var f = new FormData();
    f.append("e", email.value);
    f.append("p", password.value);
    f.append("r", r);

    var req = new XMLHttpRequest();

    req.onreadystatechange = function () {
        if (req.readyState == 4) {
            var t = req.responseText;
            if (t == "success") {
                email.value = "";
                password.value = "";
                window.location = "index.php";
            } else if (t == 1) {
                alert("Something went wrong. Please try again");
                window.location.reload();
            } else {
                document.getElementById("err").innerHTML = t;
            }
        }
    }

    req.open("POST", "signInProcess.php", true);
    req.send(f);

}

function viewpassword(x) {
    if (x == 0) {
        var input = document.getElementById("p");
        var button = document.getElementById("button-addon2");

        if (input.type == "password") {
            input.type = "text";
            button.innerHTML = '<i class="bi bi-eye-fill"></i>';
        } else {
            input.type = "password";
            button.innerHTML = '<i class="bi bi-eye-slash-fill"></i>';
        }
    } else if (x == 1) {
        var input2 = document.getElementById("npw");
        var button2 = document.getElementById("npwb");

        if (input2.type == "password") {
            input2.type = "text";
            button2.innerHTML = '<i class="bi bi-eye-fill"></i>';
        } else {
            input2.type = "password";
            button2.innerHTML = '<i class="bi bi-eye-slash-fill"></i>';
        }

    } else if (x == 2) {
        var input3 = document.getElementById("rnpw");
        var button3 = document.getElementById("rnpwb");

        if (input3.type == "password") {
            input3.type = "text";
            button3.innerHTML = '<i class="bi bi-eye-fill"></i>';
        } else {
            input3.type = "password";
            button3.innerHTML = '<i class="bi bi-eye-slash-fill"></i>';
        }
    }

}

function signOut() {

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {
                window.location.reload();
            } else if (t == 1) {
                alert("Something went wrong. Please try again later.");
                window.location.reload();
            } else {
                alert(t);
            }
        }
    };

    r.open("GET", "signOutProcess.php?acc_type=user", true);
    r.send()

}

function adminSignOut() {
    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {
                window.location = "signin.php";
            } else if (t == 1) {
                alert("Something went wrong. Please try again later.");
                window.location.reload();
            } else {
                alert(t);
            }
        }
    };

    r.open("GET", "signOutProcess.php?acc_type=admin", true);
    r.send()
}

var fpm;

function forgotPassword() {
    var m = document.getElementById("fpwmodal");
    fpm = new bootstrap.Modal(m);
    document.getElementById("email").value = "";
    fpm.show();
}

var fpemail;
var acc_type;
var rpm;

function sendEmail(x) {

    acc_type = x;

    var viewmsg = document.getElementById("viewmsg");
    viewmsg.classList = "text-success my-2";
    viewmsg.innerHTML = "Your Verification code is being generated. Please wait..."

    fpemail = document.getElementById("email").value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;

            if (t == "success") {
                viewmsg.innerHTML = "";
                fpm.hide();
                var m = document.getElementById("rpwmodal");
                rpm = new bootstrap.Modal(m);
                rpm.show();

            } else {
                viewmsg.classList = "text-danger my-2";
                viewmsg.innerHTML = t;
            }

        }
    };

    r.open("GET", "forgotPasswordProcess.php?e=" + fpemail + "&acc_type=" + acc_type, true);
    r.send();

}

function sendagain() {

    var viewmsg2 = document.getElementById("viewmsg2");
    viewmsg2.className = "text-success my-3";
    viewmsg2.innerHTML = "Please wait...";

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;

            if (t == "success") {
                viewmsg2.classList = "text-success my-3";
                viewmsg2.innerHTML = "Verification code sent. Please check your inbox.";
            } else if (t == "Something went wrong. Please try again later.") {
                alert(t);
                rpm.hide();
            } else {
                viewmsg2.classList = "text-danger my-3";
                viewmsg2.innerHTML = t;
            }

        }
    };

    r.open("GET", "forgotPasswordProcess.php?e=" + fpemail + "&acc_type=" + acc_type, true);
    r.send();

}

function resetPassword() {

    var viewmsg2 = document.getElementById("viewmsg2");
    viewmsg2.innerHTML = "";

    var vcode = document.getElementById("vcode").value;
    var npw = document.getElementById("npw").value;
    var rnpw = document.getElementById("rnpw").value;

    var f = new FormData();
    f.append("vcode", vcode);
    f.append("npw", npw);
    f.append("rnpw", rnpw);
    f.append("email", fpemail);
    f.append("acc_type", acc_type);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;

            if (t == "success") {
                vcode.value = "";
                npw.value = "";
                rnpw.value = "";
                alert("Password reset successfull!");
                rpm.hide();
            } else if (t == "Something went wrong. Please try again later.") {
                alert(t);
                rpm.hide();
            } else {
                viewmsg2.classList = "text-danger my-3";
                viewmsg2.innerHTML = t;
            }

        }
    };

    r.open("POST", "resetPasswordProcess.php", true);
    r.send(f);

}

var searchModel;

function sameAsModel() {
    var checkbox = document.getElementById("addmodelname");
    var title = document.getElementById("title");

    if (checkbox.checked) {
        searchModel = setInterval(modelNameInTitle, 100);
        title.disabled = true;
    } else {
        clearInterval(searchModel);
        title.value = "";
        title.disabled = false;
    }
}

function modelNameInTitle() {
    var model = document.getElementById("m").value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == 1) {
                clearInterval(searchModel);
                document.getElementById("addmodelname").checked = false;
                alert("Something went wrong. Please try again later.");
            } else {
                document.getElementById("title").value = t;
            }
        }
    };

    r.open("GET", "searchModelNameProcess.php?mid=" + model, true);
    r.send();

}

function loadSub() {
    var category = document.getElementById("cat").value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == 1) {
                alert("Something went wrong. Please try again later.");
            } else {
                document.getElementById("subc").innerHTML = t;
                loadBrand();
            }
        }
    };

    r.open("GET", "loadSubProcess.php?cid=" + category, true);
    r.send();

}

function loadBrand() {

    var subcat = document.getElementById("subc").value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == 1) {
                alert("Something went wrong. Please try again later.");
            } else {
                document.getElementById("b").innerHTML = t;
                loadModel();
            }
        }
    };

    r.open("GET", "loadBrandProcess.php?scid=" + subcat, true);
    r.send();

}

function loadModel() {
    var brand = document.getElementById("b").value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == 1) {
                alert("Something went wrong. Please try again later.");
            } else {
                document.getElementById("m").innerHTML = t;
            }
        }
    }

    r.open("GET", "loadModelProcess.php?bid=" + brand, true);
    r.send();

}

function addCategory() {
    var input = document.getElementById("addCat").value;
    var err = document.getElementById("errcat");

    if (input != "") {

        var confirmation = confirm("Are you sure you want to add " + input + " as a new Category?");
        if (confirmation) {

            var r = new XMLHttpRequest();

            r.onreadystatechange = function () {
                if (r.readyState == 4) {
                    var t = r.responseText;
                    if (t == 1) {
                        err.classList = "text-danger";
                        err.innerHTML = "Something went wrong. Please try again later.";
                        document.getElementById("addCat").value = "";
                        setTimeout(function () { err.innerHTML = "" }, 5000);
                    } else if (t == 2) {
                        err.classList = "text-danger";
                        err.innerHTML = "Same or similar category already exists!";
                        setTimeout(function () { err.innerHTML = "" }, 5000);
                        document.getElementById("addCat").value = "";
                    } else if (t == "success") {
                        alert("New category " + input + " added successfully");
                        window.location.reload();
                    } else {
                        alert(t);
                        document.getElementById("addCat").value = "";
                    }
                }
            };

            r.open("GET", "addCategoryProcess.php?c=" + input, true);
            r.send();

        }
    }
}

function addSubCat() {

    var input = document.getElementById("addSubCat").value;
    var err = document.getElementById("errsubc");
    var cat = document.getElementById("cat").value;

    if (input != "") {

        if (cat == 0) {
            alert("Please select a category!");
        } else {

            var confirmation = confirm("Are you sure you want to add " + input + " as a sub-category?");
            if (confirmation) {

                var r = new XMLHttpRequest();

                r.onreadystatechange = function () {
                    if (r.readyState == 4) {
                        var t = r.responseText;
                        if (t == 1) {
                            err.classList = "text-danger";
                            err.innerHTML = "Something went wrong. Please try again later.";
                            document.getElementById("addSubCat").value = "";
                            setTimeout(function () { err.innerHTML = "" }, 5000);
                        } else if (t == 2) {
                            err.classList = "text-danger";
                            err.innerHTML = "Same or similar sub-catergory already exists!";
                            setTimeout(function () { err.innerHTML = "" }, 5000);
                            document.getElementById("addSubCat").value = "";
                        } else if (t == "success") {
                            alert("New sub-category " + input + " added successfully");
                            window.location.reload();
                        } else {
                            alert(t);
                            document.getElementById("addSubCat").value = "";
                        }
                    }
                };

                r.open("GET", "addSubCatProcess.php?subc=" + input + "&cat=" + cat, true);
                r.send();

            }

        }
    }

}

function addBrand() {
    var input = document.getElementById("addb").value;
    var err = document.getElementById("errb");
    var cat = document.getElementById("cat").value;
    var subcat = document.getElementById("subc").value;

    if (input != "") {

        if (cat == 0 || subcat == 0) {

            alert("Please select the category and sub-category");

        } else {

            var confirmation = confirm("Are you sure you want to add " + input + " as a new Brand?");

            if (confirmation) {

                var r = new XMLHttpRequest();

                r.onreadystatechange = function () {
                    if (r.readyState == 4) {
                        var t = r.responseText;
                        if (t == 1) {
                            err.classList = "text-danger";
                            err.innerHTML = "Something went wrong. Please try again later.";
                            document.getElementById("addb").value = "";
                            setTimeout(function () { err.innerHTML = "" }, 5000);
                        } else if (t == 2) {
                            err.classList = "text-danger";
                            err.innerHTML = "This brand already exists!";
                            setTimeout(function () { err.innerHTML = "" }, 5000);
                            document.getElementById("addb").value = "";
                        } else if (t == "success") {
                            alert("New brand " + input + " added successfully");
                            window.location.reload();
                        } else {
                            alert(t);
                            document.getElementById("addb").value = "";
                        }
                    }
                };

                r.open("GET", "addBrandProcess.php?b=" + input + "&c=" + cat + "&sc=" + subcat, true);
                r.send();

            }

        }
    }
}

function addModel() {
    var input = document.getElementById("addm").value;
    var err = document.getElementById("errm");
    var cat = document.getElementById("cat").value;
    var subcat = document.getElementById("subc").value;
    var br = document.getElementById("b").value;

    if (input != "") {
        if (cat == 0 || subcat == 0 || br == 0) {
            alert("Please select the category and brand");
        } else {
            var confirmation = confirm("Are you sure you want to add " + input + " as a new Model?");

            if (confirmation) {

                var r = new XMLHttpRequest();

                r.onreadystatechange = function () {
                    if (r.readyState == 4) {
                        var t = r.responseText;
                        if (t == 1) {
                            err.classList = "text-danger";
                            err.innerHTML = "Something went wrong. Please try again later.";
                            document.getElementById("addm").value = "";
                            setTimeout(function () { err.innerHTML = "" }, 5000);
                        } else if (t == 2) {
                            err.classList = "text-danger";
                            err.innerHTML = "This model already exists!";
                            setTimeout(function () { err.innerHTML = "" }, 5000);
                            document.getElementById("addm").value = "";
                        } else if (t == "success") {
                            alert("New model " + input + " added successfully");
                            window.location.reload();
                        } else {
                            alert(t);
                            document.getElementById("addm").value = "";
                        }
                    }
                };

                r.open("GET", "addModelProcess.php?m=" + input + "&b=" + br, true);
                r.send();

            }

        }
    }

}

function variantSession() {

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
        }
    };

    r.open("GET", "variantSessionProcess.php", true);
    r.send();

}

function newVariant() {

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            document.getElementById("variantDiv").insertAdjacentHTML("beforeend", t);
            removeVarBtn();
        }
    };

    r.open("GET", "newVariantProcess.php", true);
    r.send();

}

function removeVarBtn() {

    var removeBtnDiv = document.getElementById("removeBtnDiv");
    var removeBtn = document.getElementById("removeBtn");

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "nosession") {
                alert("Something went wrong. Please try again later.");
            } else {

                if (t == 0) {
                    removeBtnDiv.style.display = "none";
                    removeBtn.innerHTML = "<i class='bi bi-trash-fill'>";
                } else {
                    removeBtnDiv.style.display = "block";
                    removeBtn.innerHTML = "<i class='bi bi-trash-fill'></i>&nbsp;&nbsp;Variant " + t;
                }
            }
        }
    };

    r.open("GET", "variantSessionNo.php", true);
    r.send();

}

function removeVariant() {

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "nosession") {
                alert("Something went wrong. Please try again later.");
            } else {
                var variantDiv = document.getElementById("variantDivNo" + t);
                variantDiv.remove();
                variantSessionAdjustment("1");

            }
        }
    };

    r.open("GET", "variantSessionNo.php", true);
    r.send();

}

function variantSessionAdjustment(c) {
    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "success") {
                if (c == "1") {
                    removeVarBtn();
                }

            } else {
                alert(t);
                window.location.reload();
            }
        }
    };

    r.open("GET", "variantSessionAdjustmentProcess.php", true);
    r.send();
}

function coverImages() {

    var input = document.getElementById("cImage");

    input.onchange = function () {
        var file_count = input.files.length;

        if (file_count <= 5) {
            for (var x = 0; x < file_count; x++) {
                var file = this.files[x];
                var url = window.URL.createObjectURL(file);

                document.getElementById("i" + x).src = url;
            }
        } else {
            alert("Maximum image count is 5!");
        }

    }

}

function variantImages(v) {

    var input = document.getElementById("vImage" + v);

    input.onchange = function () {
        var file_count = input.files.length;

        if (file_count <= 1) {
            for (var x = 0; x < file_count; x++) {
                var file = this.files[x];
                var url = window.URL.createObjectURL(file);

                document.getElementById("vi" + v).src = url;
            }
        } else {
            alert("Maximum image count is 5!");
        }

    }

}

function addProduct() {

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == "nosession") {
                alert("Something went wrong. Please try again later.");
            } else {
                addProductProcess(t);
            }
        }
    };

    r.open("GET", "variantSessionNo.php", true);
    r.send();
}

function addProductProcess(v) {
    if (v > 0) {
        var category = document.getElementById("cat").value;
        var subcategory = document.getElementById("subc").value;
        var brand = document.getElementById("b").value;
        var model = document.getElementById("m").value;
        var title = document.getElementById("title").value;
        var coverImg = document.getElementById("cImage");

        var f = new FormData();

        f.append("cat", category);
        f.append("subcat", subcategory);
        f.append("b", brand);
        f.append("m", model);
        f.append("t", title);

        var cfile_count = coverImg.files.length;

        for (var x = 0; x < cfile_count; x++) {
            f.append("cimg" + x, coverImg.files[x]);
        }

        f.append("c_no", cfile_count);
        f.append("v_no", v);

        //start appending variant details

        for (var y = 1; y <= v; y++) {

            var vtitle = document.getElementById("vTitle" + y).value;
            var vcon = document.getElementById("con" + y).value;
            var vcost = document.getElementById("cost" + y).value;
            var vdwc = document.getElementById("dwc" + y).value;
            var vdoc = document.getElementById("doc" + y).value;
            var vdes = document.getElementById("des" + y).value;
            var vqty = document.getElementById("qty" + y).value;
            var discount = document.getElementById("discount" + y).value;

            f.append("vtitle" + y, vtitle);
            f.append("vcon" + y, vcon);
            f.append("vcost" + y, vcost);
            f.append("vdwc" + y, vdwc);
            f.append("vdoc" + y, vdoc);
            f.append("vdes" + y, vdes);
            f.append("vqty" + y, vqty);
            f.append("discount" + y, discount);

            var vimage = document.getElementById("vImage" + y);
            var vfile_count = vimage.files.length;

            f.append("vimg_count" + y, vfile_count);
            f.append("vimg" + y, vimage.files[0]);

        }

        //end appending variant details

        var r = new XMLHttpRequest();

        r.onreadystatechange = function () {
            if (r.readyState == 4) {
                var t = r.responseText;

                var ifjson = 1;

                try {

                    var obj = JSON.parse(t);

                } catch (e) {

                    alert(t);
                    ifjson = 0;
                }


                if (ifjson == 1) {
                    if (obj.type == "error") {
                        alert("Something went wrong. Please try again.");

                    } else if (obj.type == "fullproduct") {

                        if (obj.c_img_status == 0 && obj.v_img_status == 0) {
                            alert("New Product added with " + v + " variant(s)");
                        } else if (obj.c_img_status != 0 && obj.v_img_status == 0) {
                            alert("New Product added with " + v + " variant(s). " + obj.c_img_status + " cover image(s) upload failed!");
                        } else if (obj.c_img_status == 0 && obj.v_img_status != 0) {
                            alert("New Product added with " + v + " variant(s). " + obj.v_img_status + " variant image(s) upload failed!");
                        } else {
                            alert("New Product added with " + v + " variant(s). " + obj.c_img_status + " cover image(s) and " + obj.v_img_status + " variant image(s) upload failed!");
                        }

                    } else if (obj.type == "variantonly") {

                        if (obj.blocked == "true") {

                            alert("Product is suspended! Variant updating failed");

                        } else {

                            var str = obj.vno;
                            var spt = str.split("-");
                            var amt = parseInt(obj.vamt);

                            if (amt == 0) {
                                alert("No new variants found to update!");
                            } else {

                                var text = "New Variant number(s) ";

                                for (var x = 1; x <= amt; x++) {
                                    text += "(" + spt[x] + ") ";
                                }

                                text += "updated to the existing Product!";

                                if (obj.v_img_status == 0) {
                                    alert(text);
                                } else {
                                    text += " " + obj.v_img_status + " variant image(s) upload failed!";
                                }
                            }
                        }
                    }
                    window.location.reload();
                }
            }
        };

        r.open("POST", "addProductProcess.php", true);
        r.send(f);

    } else {
        alert("Minimum one variant/type should be available!");
    }
}

function homeSort(c_no, c_id) {

    var price = document.getElementById("homePriceSort").value;
    var category_id = "0";

    var category = [];

    if (c_id == 0) {
        for (var y = 1; y <= c_no; y++) {

            category[y] = document.getElementById("categorycheck" + y);

            if (category[y].checked == true) {
                category[y].checked = false;
            }

        }
    }

    for (var x = 1; x <= c_no; x++) {

        category[x] = document.getElementById("categorycheck" + x);

        if (category[x].checked == true) {
            category_id += "," + x;
        }

    }

    var r2 = new XMLHttpRequest();

    r2.onreadystatechange = function () {
        if (r2.readyState == 4) {
            var t = r2.responseText;
            document.getElementById("viewType").innerHTML = t;
        }
    };

    r2.open("GET", "homeSortViewProcess.php?category_id=" + category_id, true);
    r2.send();

    if (c_id != undefined) {

        if (document.getElementById("categorycheck" + c_id).checked == true) {
            document.getElementById("categorycheck0").checked = false;
        }

        if (category_id == 0) {
            document.getElementById("categorycheck0").checked = true;
        }

    }

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {

            var t = r.responseText;

            if (t == 1) {
                alert("Something went wrong. Please try again.");
                window.location.reload();
            } else {
                document.getElementById("productView").innerHTML = t;
            }
        }
    };

    r.open("GET", "homeSortProcess.php?price=" + price + "&category_id=" + category_id, true);
    r.send();

}

function search() {

    var input = document.getElementById("searchInput").value;
    var category_id = document.getElementById("searchCategory").value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == 2) {
                alert("Please enter the keyword");
            } else {
                document.getElementById("mainView").innerHTML = t;
            }
        }
    };

    r.open("GET", "searchProcess.php?input=" + input + "&category_id=" + category_id, true);
    r.send();

}

function advancedSearch() {

    var title = document.getElementById("input").value;
    var category = document.getElementById("cat").value;
    var brand = document.getElementById("b").value;
    var model = document.getElementById("m").value;
    var pfrom = document.getElementById("pfrm").value;
    var pto = document.getElementById("pto").value;
    var condition = document.getElementById("con").value;
    var sort = document.getElementById("sort").value;

    var obj = {
        "title": title,
        "category": category,
        "brand": brand,
        "model": model,
        "pfrom": pfrom,
        "pto": pto,
        "condition": condition,
        "sort": sort,
    };

    var json = JSON.stringify(obj);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            if (t == 1) {
                alert("Something went wrong. Please try again.");
                window.location.reload();
            } else {
                document.getElementById("mainView").innerHTML = t;
            }
        }
    };

    r.open("POST", "advancedSearchProcess.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("json=" + json);

}

function profileImage() {
    var imageView = document.getElementById("img");
    var image = document.getElementById("proImgUploader");

    image.onchange = function () {
        var url = window.URL.createObjectURL(image.files[0]);
        imageView.src = url;
    };
}

function updateProfile() {
    var fname = document.getElementById("fn").value;
    var lname = document.getElementById("ln").value;
    var mobile = document.getElementById("m").value;
    var password = document.getElementById("pw").value;
    var gender = document.getElementById("gender").value;
    var line1 = document.getElementById("line1").value;
    var line2 = document.getElementById("line2").value;
    var province = document.getElementById("province").value;
    var district = document.getElementById("district").value;
    var city = document.getElementById("city").value;
    var postal = document.getElementById("pcode").value;
    var image = document.getElementById("proImgUploader");

    var obj = {
        "fname": fname,
        "lname": lname,
        "mobile": mobile,
        "password": password,
        "gender": gender,
        "line1": line1,
        "line2": line2,
        "province": province,
        "district": district,
        "city": city,
        "postal": postal,
    };

    var json = JSON.stringify(obj);

    var f = new FormData();
    f.append("image", image.files[0]);
    f.append("json", json);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) {
            var t = r.responseText;
            var ifjson = 1;

            try {

                var obj2 = JSON.parse(t);

            } catch (e) {

                alert(t);
                ifjson = 0;
            }

            if (ifjson == 1) {
                if (obj2.type == "error") {
                    if (obj2.errormsg == 1) {
                        alert("Something went wrong. Please try again.");
                        window.location.reload();
                    } else {
                        alert(obj2.errormsg);
                    }
                } else {
                    if (obj2.type == "ok") {

                        if (obj2.imagestatus == "no" && obj2.addressstatus == "no") {

                            alert("User details updated. Profile picture and address details are not changed.");

                        } else if (obj2.imagestatus == "notvalid" && obj2.addressstatus == "no") {

                            alert("User details updated. Address details are not changed. Profile picture update failed.");

                        } else if (obj2.imagestatus == "notupdated" && obj2.addressstatus == "no") {

                            alert("User details updated. Address details are not changed. Profile picture update failed.");

                        } else if (obj2.imagestatus == "ok" && obj2.addressstatus == "no") {

                            alert("User details and Profile picture updated. Address details are not changed.");

                        } else if (obj2.imagestatus == "no" && obj2.addressstatus == "ok") {

                            alert("User details and Address details updated. Profile picture is not changed.");

                        } else if (obj2.imagestatus == "notvalid" && obj2.addressstatus == "ok") {

                            alert("User details and Address details updated. Profile picture update failed.");

                        } else if (obj2.imagestatus == "notupdated" && obj2.addressstatus == "ok") {

                            alert("User details and Address details updated. Profile picture update failed.");

                        } else if (obj2.imagestatus == "ok" && obj2.addressstatus == "ok") {

                            alert("User details, Profile picture and Address details are updated.");

                        }

                    } else if (obj2.type == "updating") {

                        if (obj2.imagestatus == "no" && obj2.addressstatus == "no") {

                            alert("User details update failed. Profile picture and address details are not changed.");

                        } else if (obj2.imagestatus == "notvalid" && obj2.addressstatus == "no") {

                            alert("User details update failed. Address details are not changed. Profile picture update failed.");

                        } else if (obj2.imagestatus == "notupdated" && obj2.addressstatus == "no") {

                            alert("User details update failed. Address details are not changed. Profile picture update failed.");

                        } else if (obj2.imagestatus == "ok" && obj2.addressstatus == "no") {

                            alert("Profile picture updated. Address details are not changed. User details update failed.");

                        } else if (obj2.imagestatus == "no" && obj2.addressstatus == "ok") {

                            alert("Address details updated. Profile picture is not changed. User details update failed.");

                        } else if (obj2.imagestatus == "notvalid" && obj2.addressstatus == "ok") {

                            alert("Address details updated. Profile picture and user details update failed.");

                        } else if (obj2.imagestatus == "notupdated" && obj2.addressstatus == "ok") {

                            alert("Address details updated. Profile picture and user details update failed.");

                        } else if (obj2.imagestatus == "ok" && obj2.addressstatus == "ok") {

                            alert("Profile picture and Address details are updated.  User details update failed.");

                        }

                    }
                    window.location.reload();
                }
            }
        }
    };

    r.open("POST", "updateProfileProcess.php", true);
    r.send(f);

}

function notSignedIn() {
    alert("Please sign in to continue.");
    window.location = "signin.php";
}

var selectedVariant;

function loadVariant(p_id) {

    var variant = document.getElementById("variant").value;
    var variantPrice = document.getElementById("variantPrice");
    var discountedPrice = document.getElementById("discountedPrice");
    var discount = document.getElementById("discount");
    var variantDescription = document.getElementById("variantDescription");
    var variantDwc = document.getElementById("variantDwc");
    var variantDoc = document.getElementById("variantDoc");
    var variantQty = document.getElementById("variantQty");
    var variantImg = document.getElementById("variantImg");
    var buyNowBtn = document.getElementById("buyNowBtn");
    var addToCartBtn = document.getElementById("addToCartBtn");

    if (variant == 0) {
        variantImg.src = "resources/select_variant.png";
        variantPrice.classList = "px-2";
        discountedPrice.innerHTML = "";
        discount.innerHTML = "";
        variantPrice.innerHTML = "Select Variant";

        var content = `<div class="col-12 d-flex flex-column align-items-center justify-content-center my-3">
                                            <div class="col-12 my-2">
                                                <div class="row d-flex flex-row justify-content-evenly">
                                                    <img src="resources/noresults.jpg" alt="" class="img-fluid" style="width: 50rem;">
                                                    <span class="noresultsText text-center">No Variant Selected</span>
                                                </div>
                                            </div>
                                        </div>`;

        variantDescription.innerHTML = content;
        variantDwc.setAttribute("value", "Select Variant");
        variantDoc.setAttribute("value", "Select Variant");
        variantQty.setAttribute("value", "Select Variant");
        variantQty.classList = "form-control";
        buyNowBtn.setAttribute("disabled", true);
        addToCartBtn.setAttribute("disabled", true);
    } else {

        var r = new XMLHttpRequest();

        r.onreadystatechange = function () {
            if (r.readyState == 4) {
                var t = r.responseText
                var ifjson = 1;

                try {

                    var obj = JSON.parse(t);

                } catch (e) {
                    alert(t);
                    ifjson = 0;
                }

                if (ifjson == 1) {

                    if (obj.type == "success") {

                        selectedVariant = obj.data["id"];

                        variantImg.src = obj.data["image_path"];

                        variantImg.onerror = function (e) {
                            variantImg.src = "resources/no_image_available.jpg";
                        };

                        if (obj.data["discount"] == 0) {
                            variantPrice.classList = "px-2";
                            discountedPrice.innerHTML = "";
                            discount.innerHTML = "";
                        } else {
                            var disPrice = obj.data["price"] * (obj.data["discount"] / 100);
                            variantPrice.classList = "px-2 text-decoration-line-through";
                            discountedPrice.innerHTML = (obj.data["price"] - disPrice);
                            discount.innerHTML = obj.data["discount"] + "% Discount!";
                        }
                        variantPrice.innerHTML = obj.data["price"];
                        var descriptionTitle = `<span class="fs-4 fw-bold text-secondary">Description</span><br>`;
                        variantDescription.innerHTML = descriptionTitle + obj.data["description"];
                        variantDwc.setAttribute("value", obj.data["delivery_fee_within_colombo"]);
                        variantDoc.setAttribute("value", obj.data["delivery_fee_outside_colombo"]);
                        if (obj.data["qty"] == 0) {
                            variantQty.setAttribute("value", "No Stock!");
                            variantQty.classList = "form-control border-danger bg-danger bg-opacity-10 text-danger";
                            buyNowBtn.setAttribute("disabled", true);
                            addToCartBtn.setAttribute("disabled", true);

                        } else {
                            variantQty.setAttribute("value", obj.data["qty"]);
                            variantQty.classList = "form-control";
                            buyNowBtn.disabled = false;
                            addToCartBtn.disabled = false;
                        }

                    } else {
                        alert("Something went wrong. Please try again");
                        window.location.reload();
                    }
                }

            }
        };

        r.open("GET", "loadVariant.php?variant_no=" + variant + "&product_id=" + p_id, true);
        r.send();

    }

}

function addToWishlist(p_id) {

    var wishlistIcon = document.getElementById("wishlistIcon");

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "added") {
                wishlistIcon.classList = "bi bi-suit-heart-fill fs-4 text-danger";
            } else if (t == "removed") {
                wishlistIcon.classList = "bi bi-suit-heart fs-4";
            } else if (t == 1) {
                alert("Something went wrong. Please try again.");
                window.location.reload();
            } else {
                alert(t);
            }
        }
    };

    r.open("GET", "wishlistProcess.php?product_id=" + p_id, true);
    r.send();

}

function removeFromWishlist(p_id) {

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "removed") {
                window.location.reload();
            } else if (t == 1) {
                alert("Something went wrong. Please try again.");
                window.location.reload();
            } else {
                alert(t);
            }
        }
    };

    r.open("GET", "wishlistProcess.php?product_id=" + p_id, true);
    r.send();

}

function removeFromRecent(p_id, p_title) {

    var confirmation = confirm("Are you sure you want to remove " + p_title + " from recents?");

    if (confirmation) {

        var r = new XMLHttpRequest();

        r.onreadystatechange = function () {
            if (r.readyState == 4 && r.status == 200) {
                var t = r.responseText;
                if (t == "removed") {
                    window.location.reload();
                } else if (t == 1) {
                    alert("Something went wrong. Please try again.");
                    window.location.reload();
                } else {
                    alert(t);
                }
            }
        };

        r.open("GET", "removeFromRecentProcess.php?product_id=" + p_id, true);
        r.send();


    }
}

function searchWishlist() {
    var input = document.getElementById("search").value;
    var searchDiv = document.getElementById("searchContentDiv");
    var contentDiv = document.getElementById("mainContentDiv");

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "empty") {
                searchDiv.classList = "col-12 d-none";
                contentDiv.classList = "col-12";
            } else if (t == 1) {
                alert("Something went wrong. Please try again.");
                window.location.reload();
            } else {
                searchDiv.classList = "col-12";
                contentDiv.classList = "col-12 d-none";
                searchDiv.innerHTML = t;
            }
        }
    };

    r.open("GET", "searchWishlistProcess.php?input=" + input, true);
    r.send();

}

function signInAdmin() {
    var email = document.getElementById("e").value;
    var password = document.getElementById("p").value;

    if (document.getElementById("rememberMe").checked) {
        r = 1;
    } else {
        r = 0;
    }


    var obj = {
        "email": email,
        "password": password,
        "rememberMe": r
    };

    var json = JSON.stringify(obj);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            var ifjson = 1;

            try {

                var obj2 = JSON.parse(t);

            } catch (e) {
                alert(t);
                ifjson = 0;
            }

            if (ifjson == 1) {
                if (obj2.type == "success") {
                    email.value = "";
                    password.value = "";
                    window.location = "adminPanel.php";
                } else if (obj2.type == "error") {
                    if (obj2.msg == 1) {
                        alert("Something went wrong. Please try again");
                        window.location.reload();
                    } else {
                        document.getElementById("err").innerHTML = obj2.msg;
                    }
                } else {
                    alert(t);
                }
            }
        }
    };

    r.open("POST", "signInAdminProcess.php", true);
    r.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    r.send("json=" + json);

}

function userImageError(id, gender) {

    var img = document.getElementById(id);

    if (gender == "Male") {
        img.src = "resources/userMale.jpg";
    } else {
        img.src = "resources/userFemale.png";
    }

}

function productImageError(id) {
    document.getElementById(id).src = "resources/no_image_available.jpg";
};

var blockingEmail;
var userStatus;

function userBlockStatus(email) {

    blockingEmail = email;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == 1) {
                alert("Something went wrong. Please try again later.");
                window.location.reload();
            } else if (t == "active" || t == "blocked") {
                userStatus = t;
                userBlock();
            } else {
                alert(t);
            }
        }
    };

    r.open("GET", "userBlockStatusSearch.php?email=" + blockingEmail, true);
    r.send();
}

var uBlockModal;

function userBlock() {

    var blockText = document.getElementById("blockText" + blockingEmail);
    var blockBtn = document.getElementById("blockBtn" + blockingEmail);

    if (userStatus == "active") {
        var m = document.getElementById("userBlockModal");
        uBlockModal = new bootstrap.Modal(m);
        uBlockModal.show();
    } else {

        var confirmation = confirm("Are you sure you want to activate this user again?");

        if (confirmation) {
            var r = new XMLHttpRequest();

            r.onreadystatechange = function () {
                if (r.readyState == 4 && r.status == 200) {
                    var t = r.responseText;
                    if (t == 1) {
                        alert("Something went wrong. Please try again later.");
                        window.location.reload();
                    } else if (t == "active") {
                        alert("User activation successfull!");
                        blockText.innerHTML = "User is Active"
                        blockText.classList = "fw-bold text-success";
                        blockBtn.innerHTML = "Block";
                        blockBtn.classList = "mt-2 btn btn-outline-danger";
                    } else {
                        alert(t);
                    }
                }
            };

            r.open("GET", "userBlockingUnblockingProcess.php?email=" + blockingEmail + "&status=" + userStatus, true);
            r.send();
        }

    }

}

function userBlockingProcess() {

    var blockText = document.getElementById("blockText" + blockingEmail);
    var blockBtn = document.getElementById("blockBtn" + blockingEmail);
    var reason = document.getElementById("reason").value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == 1) {
                alert("Something went wrong. Please try again later.");
                window.location.reload();
            } else if (t == "blocked") {
                alert("User blocked successfully!");
                blockText.innerHTML = "User is Blocked"
                blockText.classList = "fw-bold text-danger";
                blockBtn.innerHTML = "Unblock";
                blockBtn.classList = "mt-2 btn btn-outline-success";

                uBlockModal.hide();
            } else {
                alert(t);
            }
        }
    };

    r.open("GET", "userBlockingUnblockingProcess.php?email=" + blockingEmail + "&status=" + userStatus + "&reason=" + reason, true);
    r.send();
}

function viewBlockingHistory(email) {

    var blockingHistoryView = document.getElementById("blockingHistoryView");

    var m = document.getElementById("userBlockHistoryModal");
    var blockingHistoryModal = new bootstrap.Modal(m);
    blockingHistoryModal.show();

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == 1) {
                alert("Something went wrong. Please try again later.");
                window.location.reload();
            } else {
                blockingHistoryView.innerHTML = t;
            }
        }
    };

    r.open("GET", "viewBlockingHistoryProcess.php?email=" + email, true);
    r.send();

}

function viewProductBlockingHistory(product_id) {

    var productBlockingHistoryView = document.getElementById("productBlockingHistoryView");

    var m = document.getElementById("productBlockHistoryModal");
    var productBlockHistoryModal = new bootstrap.Modal(m);
    productBlockHistoryModal.show();

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == 1) {
                alert("Something went wrong. Please try again later.");
                window.location.reload();
            } else {
                productBlockingHistoryView.innerHTML = t;
            }
        }
    };

    r.open("GET", "viewProductBlockingHistoryProcess.php?product_id=" + product_id, true);
    r.send();

}

function searchUser() {
    var userInput = document.getElementById("userInput").value;
    var userView = document.getElementById("userView");

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == 1) {
                alert("Something went wrong. Please try again later.");
                window.location.reload();
            } else {
                userView.innerHTML = t;
            }
        }
    };

    r.open("GET", "searchUserProcess.php?input=" + userInput, true);
    r.send();

}

var productStatus;
var pBlockId;
var pBlockModal;

function productBlockStatus(p_id) {

    pBlockId = p_id;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == 1) {
                alert("Something went wrong. Please try again later.");
                window.location.reload();
            } else if (t == "active" || t == "deactive") {
                productStatus = t;
                productBlock();
            } else {
                alert(t);
            }
        }
    };

    r.open("GET", "productBlockStatusSearch.php?p_id=" + p_id, true);
    r.send();

}

function toggleCheck() {
    var blockCheck = document.getElementById("productAct" + pBlockId);

    if (blockCheck.checked) {
        blockCheck.checked = false;
    } else {
        blockCheck.checked = true;
    }

}

function productBlock() {

    var blockCheck = document.getElementById("productAct" + pBlockId);
    var actDeactLabel = document.getElementById("actDeactLabel" + pBlockId);

    if (productStatus == "active") {
        var m = document.getElementById("productBlockModal");
        pBlockModal = new bootstrap.Modal(m);
        pBlockModal.show();
    } else {

        var confirmation = confirm("Are you sure you want to activate this product again?");

        if (confirmation) {
            var r = new XMLHttpRequest();

            r.onreadystatechange = function () {
                if (r.readyState == 4 && r.status == 200) {
                    var t = r.responseText;
                    if (t == 1) {
                        alert("Something went wrong. Please try again later.");
                        window.location.reload();
                    } else if (t == "active") {
                        alert("Product activation successfull!");
                        actDeactLabel.innerHTML = "Product is Active"
                        actDeactLabel.classList = "fw-bold text-success";
                        blockCheck.checked = true;
                    } else {
                        alert(t);
                    }
                }
            };

            r.open("GET", "productBlockingUnblockingProcess.php?p_id=" + pBlockId + "&status=" + productStatus, true);
            r.send();
        } else {
            toggleCheck();
        }
    }
}

function productBlockingProcess() {
    var blockCheck = document.getElementById("productAct" + pBlockId);
    var actDeactLabel = document.getElementById("actDeactLabel" + pBlockId);
    var reason = document.getElementById("reasonProduct").value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == 1) {
                alert("Something went wrong. Please try again later.");
                window.location.reload();
            } else if (t == "deactivated") {
                alert("Product deactivated successfully!");
                actDeactLabel.innerHTML = "Product is Deactive"
                actDeactLabel.classList = "fw-bold text-danger";
                blockCheck.checked = false;

                pBlockModal.hide();
            } else {
                alert(t);
            }
            document.getElementById("reasonProduct").value = "";
        }
    };

    r.open("GET", "productBlockingUnblockingProcess.php?p_id=" + pBlockId + "&status=" + productStatus + "&reason=" + reason, true);
    r.send();
}

async function updateProductPage(title, product_id) {
    variantSession();
    checkTitle(title);
    loadVariantsInUpdate(product_id);
}

function checkTitle(title) {

    var model = document.getElementById("m").value;
    var input = document.getElementById("title");

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == 1) {
                document.getElementById("addmodelname").checked = false;
                alert("Something went wrong. Please try again later.");
            } else if (t == title) {
                document.getElementById("addmodelname").checked = true;
                input.disabled = true;
            } else {
                document.getElementById("addmodelname").checked = false;
                input.disabled = false;
            }
        }
    };

    r.open("GET", "searchModelNameProcess.php?mid=" + model, true);
    r.send();
}

function loadVariantsInUpdate() {

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            document.getElementById("variantDiv").innerHTML = t;
        }
    };

    r.open("GET", "loadVariantDivProcess.php", true);
    r.send();
}

function deleteCoverImage(img_id) {

    var confirmation = confirm("Are you sure you want to delete this picture?");

    if (confirmation) {

        var r = new XMLHttpRequest();

        r.onreadystatechange = function () {
            if (r.readyState == 4 && r.status == 200) {
                var t = r.responseText;
                if (t == 1) {
                    alert("Something went wrong. Please try again later.");
                    window.location.reload();
                } else if (t == "deleted") {
                    alert("Image deleted successfully!");
                    window.location.reload();
                } else {
                    alert(t);
                }
            }
        };

        r.open("GET", "deleteCoverImageProcess.php?img_id=" + img_id, true);
        r.send();

    }

}

function newCoverImages(remaining, product_id) {
    var input = document.getElementById("cImage");

    input.onchange = function () {
        var file_count = input.files.length;

        if (file_count <= remaining) {
            for (var x = 0; x < file_count; x++) {
                var file = this.files[x];
                var url = window.URL.createObjectURL(file);

                document.getElementById("ir" + x).src = url;
            }
            newCoverImagesProcess(remaining, product_id);
        } else {
            alert("Maximum possible image count is " + remaining + "!");
        }
    }
}

function newCoverImagesProcess(remaining, product_id) {

    var input = document.getElementById("cImage");

    var f = new FormData();
    f.append("rem", remaining);
    f.append("p_id", product_id);

    var l = input.files.length

    for (var x = 0; x < l; x++) {
        f.append("cimg" + x, input.files[x]);
    }

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var responseObj = JSON.parse(r.responseText);

            if (responseObj.type == "success") {
                if (responseObj.img_status == 0) {
                    alert(l + " image(s) added");
                } else {
                    var uploaded = l - responseObj.img_status;
                    alert(uploaded + " image(s) added. " + responseObj.img_status + " failed!");
                }
                window.location.reload();
            } else {
                alert("Something went wrong. Please try again later.");
                window.location.reload();
            }
        }
    };

    r.open("POST", "addNewCoverImageProcess.php", true);
    r.send(f);

}

function changeVariantImages(v_no, v_id) {

    var input = document.getElementById("vImage" + v_no);

    input.onchange = function () {
        var file_count = input.files.length;

        if (file_count == 1) {
            var file = this.files[0];
            var url = window.URL.createObjectURL(file);
            document.getElementById("vi" + v_no).src = url;

            newVariantImagesProcess(v_no, v_id);
        } else {
            alert("Maximum possible image count is 1!");
        }
    }

}

function newVariantImagesProcess(v_no, v_id) {

    var input = document.getElementById("vImage" + v_no);

    var f = new FormData();
    f.append("v_id", v_id);
    f.append("vimg", input.files[0]);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var responseObj = JSON.parse(r.responseText);

            if (responseObj.type == "success") {
                if (responseObj.img_status == 0) {
                    alert("Variant image changed successfully!");
                } else {
                    alert("Image upload failed!");
                }
            } else {
                alert("Something went wrong. Please try again later.");
                window.location.reload();
            }
        }
    };

    r.open("POST", "addNewVariantImageProcess.php", true);
    r.send(f);
}

function deleteVariant(v_id) {

    var confirmation = confirm("Are you sure you want to delete the variant?");

    if (confirmation) {
        var r = new XMLHttpRequest();

        r.onreadystatechange = function () {
            if (r.readyState == 4 && r.status == 200) {
                var t = r.responseText;
                if (t == 1) {
                    alert("Something went wrong. Please try again later.");
                    window.location.reload();
                } else if (t == "success") {
                    alert("Variant deleted successfully");
                    window.location.reload();
                } else {
                    alert(t);
                }
            }
        };

        r.open("GET", "deleteVariantProcess.php?variant_id=" + v_id, true);
        r.send();
    }

}

function existingVariantAmount(resolve, reject) {
    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            var ifjson = 1;

            try {

                var responseObject = JSON.parse(t);

            } catch (e) {

                alert(t);
                ifjson = 0;
            }

            if (ifjson == 1) {
                if (responseObject.type = "success") {
                    resolve(responseObject.msg);

                } else {
                    return "failure";
                }
            } else {
                return "failure";
            }

        }
    };

    r.open("GET", "existingVariantsAmount.php", true);
    r.send();
}

function removeUpdateVariant() {

    var removeBtnDiv = document.getElementById("removeBtnDiv");
    var removeBtn = document.getElementById("removeBtn");

    var variant_no;

    var r = new XMLHttpRequest();

    r.onreadystatechange = async function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "nosession") {
                alert("Something went wrong. Please try again later.");
            } else {
                variant_no = t;
                var variantDiv = document.getElementById("variantDivNo" + t);
                variantDiv.remove();
                variantSessionAdjustment("0");

                var promise = new Promise(existingVariantAmount);

                promise.then(
                    function (value) {
                        if (value == (variant_no - 1)) {
                            removeBtnDiv.style.display = "none";
                            removeBtn.innerHTML = "<i class='bi bi-trash-fill'>";
                        } else {
                            removeBtnDiv.style.display = "block";
                            removeBtn.innerHTML = "<i class='bi bi-trash-fill'></i>&nbsp;&nbsp;Variant " + (variant_no - 1);
                        }
                    }
                );

            }
        }
    };

    r.open("GET", "variantSessionNo.php", true);
    r.send();

}

function updateProduct() {
    var promise = new Promise(function (resolve, reject) {
        var r = new XMLHttpRequest();

        r.onreadystatechange = function () {
            if (r.readyState == 4 && r.status == 200) {
                var t = r.responseText;
                if (t == "nosession") {
                    alert("Something went wrong. Please try again later.");
                } else {
                    resolve(t);
                }
            }
        };

        r.open("GET", "variantSessionNo.php", true);
        r.send();
    });

    promise.then(
        function (value) {
            var title = document.getElementById("title").value;
            var v_no = value;

            var f = new FormData();
            f.append("t", title);

            f.append("v_no", value);

            var promise = new Promise(existingVariantAmount);

            promise.then(
                function (value) {
                    f.append("ex_v_no", value);

                    //appending variant details

                    for (var y = 1; y <= v_no; y++) {

                        var vtitle = document.getElementById("vTitle" + y).value;
                        var vcon = document.getElementById("con" + y).value;
                        var vcost = document.getElementById("cost" + y).value;
                        var vdwc = document.getElementById("dwc" + y).value;
                        var vdoc = document.getElementById("doc" + y).value;
                        var vdes = document.getElementById("des" + y).value;
                        var vqty = document.getElementById("qty" + y).value;
                        var discount = document.getElementById("discount" + y).value;

                        f.append("vtitle" + y, vtitle);
                        f.append("vcon" + y, vcon);
                        f.append("vcost" + y, vcost);
                        f.append("vdwc" + y, vdwc);
                        f.append("vdoc" + y, vdoc);
                        f.append("vdes" + y, vdes);
                        f.append("vqty" + y, vqty);
                        f.append("discount" + y, discount);

                        if (y > value) {
                            var vimage = document.getElementById("vImage" + y);
                            var vfile_count = vimage.files.length;

                            f.append("vimg_count" + y, vfile_count);
                            f.append("vimg" + y, vimage.files[0]);
                        }

                    }

                    //appending variant details

                    var r = new XMLHttpRequest();

                    r.onreadystatechange = function () {
                        if (r.readyState == 4 && r.status == 200) {
                            var t = r.responseText;
                            if (t == "success") {
                                if (v_no == value) {
                                    alert("Existing variants updated successfully!");
                                } else {
                                    alert("Existing variants updated successfully! " + (v_no - value) + " new variants added successfully!");
                                }
                                window.location.reload();
                            } else {
                                alert(t)
                            }
                        }
                    };

                    r.open("POST", "updateProductProcess.php", true);
                    r.send(f);

                }
            );

        }
    );

}

function deleteProduct(product_id) {

    var confirmation = confirm("Are you sure you want to delete this product?. This cannot be undone.");

    if (confirmation) {
        var r = new XMLHttpRequest();

        r.onreadystatechange = function () {
            if (r.readyState == 4 && r.status == 200) {
                var t = r.responseText;
                if (t == 1) {
                    alert("Something went wrong. Please try again later");
                    window.location.reload();
                } else if (t == "success") {
                    alert("Product with id " + product_id + " deleted successfully!");
                    window.location.reload();
                } else {
                    alert(t);
                }
            }
        };

        r.open("GET", "deleteProductProcess.php?product_id=" + product_id, true);
        r.send();
    }

}

function searchProduct() {
    var productInput = document.getElementById("productInput").value;
    var productView = document.getElementById("productView");

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == 1) {
                alert("Something went wrong. Please try again later");
                window.location.reload();
            } else {
                productView.innerHTML = t;
            }
        }
    };

    r.open("GET", "searchProductProcess.php?input=" + productInput, true);
    r.send();

}

function addToCart() {

    var selectedQty = document.getElementById("selectedQty").value;

    if (selectedQty > 0) {
        var f = new FormData();
        f.append("selectedQty", selectedQty);
        f.append("selectedVariant", selectedVariant);

        var r = new XMLHttpRequest();

        r.onreadystatechange = function () {
            if (r.readyState == 4 && r.status == 200) {
                var t = r.responseText;
                if (t == "success") {
                    alert("Added to cart successfully!");
                } else if (t == 1) {
                    alert("Something went wrong. Please try again later");
                    window.location.reload();
                } else {
                    alert(t);
                }
            }
        };

        r.open("POST", "addToCartProcess.php", true);
        r.send(f);
    } else {
        alert("Please select a valid quantity");
        document.getElementById("selectedQty").value = 1;
    }

}

function quantityChange(variant_id, change) {

    var selectedQty = document.getElementById("selectedQty" + variant_id).innerHTML;

    var f = new FormData();
    f.append("variant_id", variant_id);
    f.append("selectedQty", selectedQty);
    f.append("change", change);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "error") {
                alert("Something went wrong. Please try again later");
                window.location.reload();
            } else if (t == "qtyerror") {
                alert("Maximum available quantity exceeded!");
            } else if (t == "minqty") {
                alert("Minimum selected qty should be 1!");
            } else {
                document.getElementById("selectedQty" + variant_id).innerHTML = t
                loadCartSummary();
            }
        }
    };

    r.open("POST", "changeCartQtyProcess.php", true);
    r.send(f);
}

function loadCartSummary() {

    if (document.getElementById("summaryView")) {
        var r = new XMLHttpRequest();

        r.onreadystatechange = function () {
            if (r.readyState == 4 && r.status == 200) {
                var t = r.responseText;
                if (t == 1) {
                    alert("Something went wrong. Please try again later");
                    window.location = "index.php";
                } else {
                    document.getElementById("summaryView").innerHTML = t;
                }
            }
        };

        r.open("GET", "loadCartSummaryProcess.php", true);
        r.send();
    }

}

function removeFromCart(cart_id) {

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == 1) {
                alert("Something went wrong. Please try again later");
                window.location.reload();
            } else if (t == "success") {
                alert("Product removed successfully");
                window.location.reload();
            } else {
                alert(t);
            }
        }
    };

    r.open("GET", "removeFromCartProcess.php?cart_id=" + cart_id, true);
    r.send();
}

//-----------------------------------------------
//   PAYHERE JAVASCRIPT SDK INTEGRATION START
//-----------------------------------------------

function buyNow() {
    var selectedQty = document.getElementById("selectedQty").value;

    var f = new FormData();
    f.append("selectedVariant", selectedVariant);
    f.append("selectedQty", selectedQty);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == 1) {
                alert("Something went wrong. Please try again later");
                window.location.reload();
            } else if (t == "incompleteProfile") {
                alert("Please complete your address details.");
                window.location = "profile.php";
            } else if (t == "notAvailable") {
                alert("This product has been suspended. You will be redirected to the home page. Sorry for any inconvenience caused.");
                window.location = "index.php";
            } else if (t == "notSignedIn") {
                alert("Please sign in to continue.");
                window.location = "signin.php";
            } else {

                var orderObject = JSON.parse(t);

                generatePaymentHash(orderObject, false);

            }
        }
    };

    r.open("POST", "buyNowProcess.php", true);
    r.send(f);

}

function checkoutCart() {
    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == 1) {
                alert("Something went wrong. Please try again later");
                window.location.reload();
            } else if (t == "incompleteProfile") {
                alert("Please complete your address details.");
                window.location = "profile.php";
            } else if (t == "notSignedIn") {
                alert("Please sign in to continue.");
                window.location = "signin.php";
            } else {
                var orderObject = JSON.parse(t);
                generatePaymentHash(orderObject, true);
            }
        }
    }

    r.open("GET", "checkoutCartProcess.php", true);
    r.send();
}

function generatePaymentHash(orderObject, isCart) {
    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            if (r.responseText == 1) {
                alert("Something went wrong. Please try again later");
                window.location.reload();
            } else if (r.responseText.match(/^[A-Za-z0-9]*$/)) {
                orderObject["hash"] = r.responseText;
                processPayhereGateway(orderObject, isCart);
            } else {
                alert("Action Failed. Error: " + r.responseText);
                window.location.reload();
            }
        }
    }

    r.open("GET", "generatePayhereHash.php?order_id=" + orderObject.orderID + "&amount=" + orderObject.amount, true);
    r.send();
}

var payment = {};

function processPayhereGateway(orderObject, isCart) {

    var m1 = document.getElementById("payhereErrModal");
    var m2 = document.getElementById("payhereDisModal");
    var payhereErrModal = new bootstrap.Modal(m1);
    var payhereDisModal = new bootstrap.Modal(m2);

    // Payment completed. It can be a successful failure.
    payhere.onCompleted = function onCompleted(orderId) {
        paymentUpdate(orderObject, isCart);
    };

    // Payment window closed
    payhere.onDismissed = function onDismissed() {
        payhereDisModal.show();
    };

    // Error occurred
    payhere.onError = function onError(error) {
        payhereErrModal.show();
    };

    // Put the payment variables here
    payment = {
        "sandbox": true,
        "merchant_id": "1221370",
        "return_url": "http://sample.com/notify",
        "cancel_url": "http://sample.com/notify",
        "notify_url": "http://sample.com/notify",
        "order_id": orderObject["orderID"],
        "items": orderObject["items"],
        "amount": orderObject["amount"],
        "currency": "LKR",
        "hash": orderObject["hash"],
        "first_name": orderObject["firstname"],
        "last_name": orderObject["lastname"],
        "email": orderObject["email"],
        "phone": orderObject["mobile"],
        "address": orderObject["address"],
        "city": orderObject["city"],
        "country": "Sri Lanka",
        "delivery_address": orderObject["address"],
        "delivery_city": orderObject["city"],
        "delivery_country": "Sri Lanka",
        "item_name_1": orderObject["item_name_1"],
        "amount_1": orderObject["amount_1"],
        "quantity_1": orderObject["quantity_1"],

    };

    if (isCart) {
        for (var x = 2; x <= orderObject.itemCount; x++) {
            payment["item_name_" + x] = orderObject["item_name_" + x];
            payment["amount_" + x] = orderObject["amount_" + x];
            payment["quantity_" + x] = orderObject["quantity_" + x];
        }
    }

    // Show the payhere.js popup
    payhere.startPayment(payment);

}

function paymentUpdate(orderObject, isCart) {
    var r = new XMLHttpRequest();

    var f = new FormData();
    f.append("orderObject", JSON.stringify(orderObject));
    f.append("isCart", isCart);

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == 1) {
                alert("Payment Update error. Please contact admin.");
            } else if (t == "success") {
                generateInvoice(orderObject, isCart)
            } else {
                alert("Payment Update error. Please contact admin. Error Note: " + t);
            }
        }
    }

    r.open("POST", "paymentUpdate.php", true);
    r.send(f);
}

function generateInvoice(orderObject, isCart) {

    var form = document.createElement('form');
    form.setAttribute('method', 'POST');
    form.setAttribute('action', 'invoice.php');

    var objectField = document.createElement('input');
    objectField.setAttribute('type', 'hidden');
    objectField.setAttribute('name', 'orderObject');
    objectField.setAttribute('value', JSON.stringify(orderObject));

    var isCartField = document.createElement('input');
    isCartField.setAttribute('type', 'hidden');
    isCartField.setAttribute('name', 'isCart');
    isCartField.setAttribute('value', isCart);

    form.appendChild(objectField);
    form.appendChild(isCartField);
    document.body.appendChild(form);

    form.submit();

}

function printInvoice() {
    alert("inprint")
    var printContent = document.getElementById("invoice").innerHTML;

    var printWindow = window.open("", "", "height=600,width=800");

    var links = `<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
        <link rel="stylesheet" href="style.css" />
        <link rel="stylesheet" href="./css/main.min.css">
        <link rel="icon" href="resources/logo_title.png" />`;

    printWindow.document.write("<html><head><title>Invoice Print</title>" + links);
    printWindow.document.write("</head><body class='row d-flex justify-content-center'>");
    printWindow.document.write(printContent);
    printWindow.document.write("</body></html>");

    printWindow.document.close();

    printWindow.print();

}

//-----------------------------------------------
//   PAYHERE JAVASCRIPT SDK INTEGRATION END
//-----------------------------------------------

function viewPurchaseDetails(order_id, date) {
    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == 1) {
                alert("Error occured. Please try again later");
                window.location.reload();
            } else if (t == "success") {
                var m = document.getElementById("purchaseHistoryM");
                historyModal = new bootstrap.Modal(m);
                historyModal.show();
            } else if (t == "incompleteProfile") {
                alert("Please complete your address details.");
                window.location = "profile.php";
            } else {
                var orderObject = JSON.parse(t);
                generateInvoice(orderObject, true);
            }
        }
    }

    r.open("POST", "viewInvoiceProcess.php?order_id=" + order_id + "&date=" + date, true);
    r.send();
}

var chartData = {};

function toggleChartView(state) {
    var chartDiv = document.getElementById("chartDiv");
    var chartSpinner = document.getElementById("chartSpinner");

    if (state == "show") {
        chartDiv.classList = "row"
        chartSpinner.classList = "w-100 d-flex justify-content-center my-5 d-none"
    } else {
        chartDiv.classList = "row d-none"
        chartSpinner.classList = "w-100 d-flex justify-content-center my-5"
    }

}

function loadChartData() {
    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            chartData = JSON.parse(t);
            loadCharts();
        }
    }

    r.open("GET", "loadChartsProcess.php", true);
    r.send();
}

function loadCharts() {

    var xValuesSelling = chartData["days"];
    var yValuesSelling = chartData["daysQty"];
    // var yValuesSelling = [55, 49, 44, 24, 25, 34, 45];
    var barColorsSelling = [
        "#b91d47",
        "#00aba9",
        "#2b5797",
        "#e8c3b9",
        "#1e7145",
        "#5a337d",
        "#7d4d33"
    ];

    var xValuesCategory = chartData["categories"];
    var yValuesCategory = chartData["categoriesQty"];
    // var yValuesCategory = [55, 49, 44, 24, 15, 23, 12];
    var barColorsCategory = [
        "#b91d47",
        "#00aba9",
        "#2b5797",
        "#e8c3b9",
        "#1e7145",
        "#5a337d",
        "#7d4d33"
    ];

    new Chart("sellingsChart", {
        type: "bar",
        data: {
            labels: xValuesSelling,
            datasets: [{
                backgroundColor: barColorsSelling,
                data: yValuesSelling
            }]
        },
        options: {
            legend: { display: false },
            title: {
                display: true,
                text: "Sellings Past 7 Days"
            }
        }
    });

    new Chart("categoryChart", {
        type: "pie",
        data: {
            labels: xValuesCategory,
            datasets: [{
                backgroundColor: barColorsCategory,
                data: yValuesCategory
            }]
        },
        options: {
            title: {
                display: true,
                text: "Selling Category Distribution"
            }
        }
    });

    toggleChartView("show");
}

function viewPurchaseDetails(inv_id) {

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == "1") {
                alert("Error occured. Please try again later");
                window.location.reload();
            } else {
                document.getElementById("moreDetailsView").innerHTML = t;
                var m = document.getElementById("moreDetailsModal");
                reviewModal = new bootstrap.Modal(m);
                reviewModal.show();
            }
        }
    }

    r.open("GET", "viewPurchaseDetailsProcess.php?inv_id=" + inv_id, true);
    r.send();

}

var reviewStarCount;

function fillReviewStars(count) {
    reviewStarCount = count;
    for (var x = 1; x <= 5; x++) {

        if (x <= count) {
            document.getElementById("reviewStar" + (x)).classList = "bi bi-star-fill text-warning";
        } else {
            document.getElementById("reviewStar" + (x)).classList = "bi bi-star text-warning";
        }

    }
}

function reviewPurchase(item_id) {

    var reviewComment = document.getElementById("reviewComment").value;

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var t = r.responseText;
            if (t == 1) {
                alert("Error occured. Please try again later.");
            } else if (t == "success1") {
                alert("Review added successfully");
            } else if (t == "success2") {
                alert("Review updated successfully");
            } else {
                alert("Error occured. Please try again later. Error Note:" + t);
            }
            window.location.reload();
        }
    }

    r.open("GET", "reviewProductProcess.php?count=" + reviewStarCount + "&comment=" + reviewComment + "&item_id=" + item_id, true);
    r.send();
}