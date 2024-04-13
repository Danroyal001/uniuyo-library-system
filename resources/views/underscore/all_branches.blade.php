<tr>
    <td><%= obj.id %></td>
    <td><%= obj.branch %></td>
    <td>
        <a class="btn btn-success" data-status="branch" onclick="editData(this)" data-id="<%= obj.id %>"
            data-name="<%= obj.branch %>">Edit</a>
        <a class="btn btn-danger" data-id="<%= obj.id %>"
            onclick="handleDeleteData(<%= obj.id %>, this, 'branch')">Delete</a>
    </td>
</tr>
