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
                            <small>Members Joined: ${group.member_count}</small>
                        </div>
                        <button class="join-btn btn btn-success" data-id="${group.group_id}">
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
         $("#invite_members").prop("disabled", true);
         $("#leave_group").prop("disabled", true);
         $(".pending_invites_table").hide();
         $(".group_members_table").hide();
         $("#group_name").html("Wala ka pa group bai");
      } else {
         let group = JSON.parse(response);
         $("#invite_members").prop("disabled", false);
         $("#leave_group").prop("disabled", false);
         $(".pending_invites_table").show()
         $(".group_members_table").show();
         $("#group_name").html("Group: " + group);
      }
   })
}


function display_group_invitations() {
   $.get("../../crud/php/fetch_group_invitations.php", function (response) {
      const invitations = JSON.parse(response);
      let display = "";

      if (invitations.length === 0) {
         display = `
                <li class="list-group-item text-center text-muted">
                    No invitations found.
                </li>
            `;
      } else {
         invitations.forEach(inv => {
            display += `
                    <li class="list-group-item">
                        <div class="item-info">
                            <strong>${inv.group_name}</strong>
                            <span>From: ${inv.sender}</span>
                            <span>To: ${inv.reciever}</span>
                        </div>
                        <div class="item-footer">
                            <button 
                                class="action-btn deposit-btn btn-sm accept-invitation" 
                                data-id="${inv.group_id}">
                                Accept
                            </button>
                            <button 
                                class="action-btn withdraw-btn btn-sm decline-invitation" 
                                data-id="${inv.group_id}">
                                Decline
                            </button>
                        </div>
                    </li>
                `;
         });
      }

      // Replace all list items at once
      $("#group_invitations_list").html(display);
   });
}


function fetch_unread_notifications() {
   $.get("../../crud/php/fetch_unread_notifications.php",function(response) {
      let unread = JSON.parse(response);

      if (unread.length >0) {
         $("#notifBadge").text(unread.length).show();
      } else {
         $("#notifBadge").hide();
      }
   });
}


function fetch_activity_logs() {
   $.get("../../crud/php/activity_log.php", function(response) {
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


//count members and pending invites
// function member_count() {
//    $.get("../../crud/php/fetch_groups.php", function (response) {
//       let member_count = JSON.parse(response)
//       alert(member_count.member_count);
//    })
// }
