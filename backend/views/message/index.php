<?php

use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = "Send Message";
?>

<div class="row">
    <div class="col-md-4">
        <h5>Users</h5>
        <div class="input-group">
            <input id="user-search" class="form-control" type="search" placeholder="Search users..." aria-label="Search">
            <button class="btn btn-primary" id="search-btn">
                <i class="fas fa-search"></i>
            </button>
        </div>
        <ul id="user-list" class="list-group">
            <?php foreach ($users as $user): ?>
                <li class="list-group-item d-flex align-items-center">
                    <input type="radio" name="selectedUser" class="user-radio me-2" value="<?= Html::encode($user->username) ?>">
                    <span class="username"><?= Html::encode($user->username) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="col-md-8">
        <h5>Chat</h5>
        <div id="chat-box" class="border p-3" style="height: 300px; overflow-y: scroll;"></div>

        <?php $form = ActiveForm::begin([
            'id' => 'message-form',
            'action' => Url::to(['message/send']),
            'method' => 'post',
        ]); ?>
        <div class="input-group">
            <input type="hidden" id="selected-user" name="username">
            <input type="text" id="message-text" name="message" class="form-control" placeholder="Type a message...">
            <button class="btn btn-primary" type="submit"><i class="fas fa-paper-plane"></i></button>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<style>
    .user-item.active {
        background-color: #007bff;
        color: white;
    }
</style>

<script>
    $(document).ready(function() {
        let selectedUser = "";

        $(document).on("change", ".user-radio", function() {
            let selectedUser = $(this).val();// Store selected user
            $("#selected-user").val(selectedUser);
            console.log("Selected User:", selectedUser);
            $(".user-radio").prop("checked", false);
            $(this).prop("checked", true);
            $("#chat-box").html("");  // Clear previous messages
        });

        $("#message-form").submit(function(event) {
            event.preventDefault();
            let selectedUser = $("#selected-user").val().trim();
            let message = $("#message-text").val().trim();
            console.log("Submitting message to:", selectedUser);
            if (!selectedUser) {
                alert("Please select a user.");
                return;
            }

            if (!message) {
                alert("Please enter a message.");
                return;
            }

            $.post("<?= Url::to(['message/send']) ?>",
                { username: selectedUser, message: message },
                function(response) {
                    console.log(response); // Debugging: Check if response is actually received
                    let res = JSON.parse(response);
                    if (res.status === "success") {
                        $("#chat-box").append(`<div><strong>Admin:</strong> ${message}</div>`);
                        $("#message-text").val("");
                    } else {
                        alert("Error sending message. Please try again.");
                    }
                }
            ).fail(function(xhr, status, error) {
                console.error("AJAX Error:", xhr.responseText);
                alert("An error occurred: " + xhr.responseText);
            });
        });

        $("#search-btn").click(function() {
            let query = $("#user-search").val().toLowerCase();
            filterUsers(query);
        });

        $("#user-search").on("keyup", function(event) {
            if (event.key === "Enter") {
                let query = $(this).val().toLowerCase();
                filterUsers(query);
            }
        });

        function filterUsers(query) {
            $("#user-list li").each(function() {
                let username = $(this).find(".username").text().toLowerCase();
                $(this).toggle(username.includes(query));
            });
        }
    });
</script>