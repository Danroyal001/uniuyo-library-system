<tr>
    <td><%= obj.id %></td>
    <td><%= obj.category %></td>
    <td><%= obj.max_allowed %></td>
    <td>
        <a class="btn btn-success edit-category" data-status="category" onclick="editData(this)" data-id="<%= obj.cat_id %>"
            data-name="<%= obj.category %>" data-max="<%= obj.max_allowed %>">Edit</a>
        <a class="btn btn-danger" data-id="<%= obj.cat_id %>"
            onclick="handleDeleteData(<%= obj.cat_id %>, this, 'category')">Delete</a>
    </td>
</tr>
