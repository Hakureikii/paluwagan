// Form Group Function
function form_group(group_name, capacity) {

   if (capacity > 5 && capacity < 9) {
      $.post("../../crud/php/form_group.php",
         {
            group_name: group_name,
            capacity: capacity
         },
         function (response) {
            if (response === "err") {
               alert("Fields should be filled up!")
            } else if (response === "You are currently on a group!") {
               alert(response);
            } else {
               window.location.href = "../../templates/members/view_group.php";
            }
         })
   } else {
      let message = document.getElementById("error-message");
      message.innerHTML = `<p> Group capacity should be a minimum of 6 members and a max of 8 members </p>`;
      $("#error-message").fadeOut(3000);
   }

}

function send_member_invites(selected_members) {
   $.post("../../crud/php/send_member_invites.php", { members: selected_members }, function (response) {
      alert(response);
      display_pending_invites();
   })
}


// send join group requests
$(document).on('click', '.join-btn', function () {
   let group_id = $(this).data("group-id");
   $.post("../../crud/php/send_join_requests.php", { group_id: group_id }, function (response) {
      if (response === "request sent") {
         let request_modal = new bootstrap.Modal(document.getElementById('request_sent'));
         request_modal.show();
      }
   });

})


function deposit(amount) {
   $.post("../../crud/php/deposit.php", { amount: amount }, function (response) {
      alert(response)
      if (response === "complete") {
         alert("Transaction Complete!");
      }
   });
}


function withdraw(amount) {
   $.post("../../crud/php/withdraw.php", { amount: amount }, function (response) {
      alert(response)
      if (response === "complete") {
         alert("Transaction Complete!");
      }
   });
}


function start_rotation(status) {
   $.post("../../crud/php/start_rotation.php", { status: status }, function (response) {
      // If PHP returns "rotation started!"
      if (response.trim() === "rotation started!") {
         let rotationModal = new bootstrap.Modal(document.getElementById('rotationModal'));
         rotationModal.show();
         ongoing_rotation();
      } else {
         let rotationModal = new bootstrap.Modal(document.getElementById('rotationModalFail'));
         rotationModal.show();
      }
   });
}


// accept join requests
$(document).on('click', '.accept-request', function () {
   let member_id = $(this).data("member-id");

   $.post("../../crud/php/accept_request.php", { member_id: member_id }, function (accept_response) {
      if (accept_response === "accepted request") {
         let modal_accept = new bootstrap.Modal(document.getElementById('request_accepted'));
         modal_accept.show();
         load_all_notifications();
      }

   });
});