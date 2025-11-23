// Fetch and display groups
function display_groups() {
   $.get("../../crud/php/fetch_groups.php", function (response) {
      let groups = JSON.parse(response);
      let display = "";

      if (groups === false) {
         display = `
                <div class="text-center text-muted py-3">
                    No groups available to join.
                </div>`;
      } else {
         groups.forEach(group => {
            display += `
                    <div class="group-card d-flex justify-content-between align-items-center mb-3 p-3 shadow-sm rounded" 
                         style="background: var(--card);">
                        <div>
                            <h5 class="mb-1">${group.group_name}</h5>
                            <small>Capacity: ${group.group_capacity}</small><br>
                            <small>Members Joined: ${group.total_members}</small><br>
                            <small>Current Pot Money: ₱${group.total_contributions}</small>
                        </div>
                        <button class="join-btn btn btn-success" data-group-id="${group.group_id}">
                            <i class="fa-solid fa-user-plus me-1"></i> Join
                        </button>
                    </div>
                `;
         });
      }

      $("#groupsContainer").html(display);
   });
}



function display_group_members() {
   $.get("../../crud/php/fetch_group_members.php", function (response) {
      let members = JSON.parse(response);
      let display = "";

      for (let i = 0; i < members.length; i++) {
         display +=
            `<tr>
            <td> ${i + 1} </td>
            <td> ${members[i].name} </td>
         </tr>`
      }
      $("#group_members_table").html(display);
   })
}


function display_pending_invites() {
   $.get("../../crud/php/fetch_pending_invites.php", function (response) {
      let pending = JSON.parse(response);
      let display = ""

      for (let i = 0; i < pending.length; i++) {
         display +=
            `<tr>
            <td> ${i + 1} </td>
            <td> ${pending[i].group_name} </td>
            <td> ${pending[i].sender} </td>
            <td> ${pending[i].reciever} </td>
            <td> ${"Pending"} </td>
         </tr>`
      }
      $("#pending_invites_table").html(display);
   })
}


function display_group_name() {
   $.get("../../crud/php/fetch_group_name.php", function (response) {
      if (response === "no group") {
         $("#start_rotation").prop("disabled", true);
         $("#invite_members").prop("disabled", true);
         $("#leave_group").prop("disabled", true);
         $(".pending_invites_table").hide();
         $(".group_members_table").hide();
         $("#group_name").html("Wala ka pa group bai");
      } else {
         let group = JSON.parse(response);
         $("#start_rotation").prop("disabled", false);
         $("#invite_members").prop("disabled", false);
         $("#leave_group").prop("disabled", false);
         $(".pending_invites_table").show()
         $(".group_members_table").show();
         $("#group_name").html("Group: " + group);
      }
   })
}


function load_all_notifications() {

   // 1) Fetch group invitations
   $.get("../../crud/php/fetch_group_invitations.php", function (invResponse) {
      const invitations = JSON.parse(invResponse);

      // 2) Fetch normal notifications
      $.get("../../crud/php/notifications.php", function (notifResponse) {
         const notifications = JSON.parse(notifResponse);

         // 3) Fetch join requests
         $.get("../../crud/php/fetch_join_requests.php", function (joinResponse) {
            let joinRequests = [];

            if (joinResponse !== "none") {
               joinRequests = JSON.parse(joinResponse);
            }

            let display = "";

            // If ALL are empty
            if (
               invitations.length === 0 &&
               notifications.length === 0 &&
               joinRequests.length === 0
            ) {
               display = `
                        <li class="list-group-item text-center text-muted">
                            No notifications.
                        </li>
                    `;
            }

            // --- JOIN REQUESTS ---
            joinRequests.forEach(req => {
               display += `
                        <li class="list-group-item">
                            <div class="item-info">
                                <strong>Join Request:</strong>
                                <span>From: ${req.sender}</span>
                                <span>Message: ${req.message}</span>
                            </div>

                            <div class="item-footer mt-2">
                                <button class="btn btn-success btn-sm accept-request" 
                                        data-member-id="${req.member_id}">
                                    Accept
                                </button>

                                <button class="btn btn-danger btn-sm decline-request" 
                                        data-member-id="${req.member_id}">
                                    Decline
                                </button>
                            </div>
                        </li>
                    `;
            });

            // --- GROUP INVITATIONS ---
            invitations.forEach(inv => {
               display += `
                        <li class="list-group-item">
                            <div class="item-info">
                                <strong>Group Invitation:</strong>
                                <span>Group: ${inv.group_name}</span>
                                <span>From: ${inv.sender}</span>
                            </div>

                            <div class="item-footer mt-2">
                                <button class="btn btn-success btn-sm accept-invitation" 
                                        data-id="${inv.group_id}">
                                    Accept
                                </button>

                                <button class="btn btn-danger btn-sm decline-invitation" 
                                        data-id="${inv.group_id}">
                                    Decline
                                </button>
                            </div>
                        </li>
                    `;
            });

            // --- NORMAL NOTIFICATIONS ---
            notifications.forEach(notif => {
               display += `
                        <li class="list-group-item">
                            <div class="item-info">
                                <strong>Notification:</strong>
                                <span>${notif.description}</span>
                                <span class="text-muted">${notif.date}</span>
                            </div>
                        </li>
                    `;
            });
            // Render ALL notifications in the same list
            $("#all_notifications_list").html(display);

         }); // end join request
      }); // end notifications
   }); // end invitations
}


function fetch_unread_notifications() {
   $.get("../../crud/php/fetch_unread_notifications.php", function (response) {
      let unread = JSON.parse(response);

      if (unread.length > 0) {
         $("#notifBadge").text(unread.length).show();
      } else {
         $("#notifBadge").hide();
      }
   });
}


function notify_payout() {
   $.get("../../crud/php/notify_payout.php", function (response) {
      if (response === "Already notified or not yet") {
         return;
      }
   });
}


function notify_end_cycle() {
   $.get("../../crud/php/notify_end.php", function (response) {
      if (response === "end") {
         let myModal = new bootstrap.Modal(document.getElementById('end_cycle'));
         myModal.show();
      }
   });
}


function fetch_activity_logs() {
   $.get("../../crud/php/activity_log.php", function (response) {
      let activity = JSON.parse(response);
      let display_activity = "";

      activity.forEach(activity_log => {
         display_activity += `<tr>
            <td> ${activity_log.title} </td>
            <td> ${activity_log.description} </td>
            <td> ${activity_log.date} </td>
         </tr>`
      });
      $("#activity-log-table").html(display_activity);
   });
}


// CHECK IF MEMBER IS IN A GROUP
function check_group_status() {
   $.get("../../crud/php/check_group_status.php", function (response) {
      response = response.trim();

      if (response === "false") {
         // Top bar buttons
         $(".main-content .deposit-btn").prop("disabled", true);
         $(".main-content .withdraw-btn").prop("disabled", true);

         // Sidebar buttons
         $(".nav-links .deposit-btn").prop("disabled", true);
      } else {
         // Top bar buttons
         $(".main-content .deposit-btn").prop("disabled", false);
         $(".main-content .withdraw-btn").prop("disabled", true);

         // Sidebar buttons
         $(".nav-links .deposit-btn").prop("disabled", false);
         $(".main-content .withdraw-btn").prop("disabled", true);
      }
   });
}


function ongoing_rotation() {
   $.get("../../crud/php/start_rotation_button.php", function (response) {
      if (response === "enable") {
         $(".start-rotation-btn").prop("disabled", false);
      } else if (response === "disable") {
         $(".start-rotation-btn").prop("disabled", true);
      } else {
         alert(response);
      }
   });
}



function enable_withdrawal() {
   $.get("../../crud/php/enable_withdrawal.php", function (response) {
      if (response === "disable") {
         $(".main-content .withdraw-btn").prop("disabled", true);
      } else if (response === "enable") {
         $(".main-content .withdraw-btn").prop("disabled", false);
      } else {
         alert(response);
      }
   });
}