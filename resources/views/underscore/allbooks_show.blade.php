<tr>
    <td><%= obj.book_id %></td>
    <td title="Description: <%= obj.description %>"><%= obj.title %></td>
    <td><%= obj.author %></td>
    <td><%= obj.category %>
    </td>
    <td><a class="btn btn-success"><%= obj.avaliable %></a></td>
    <td><a class="btn btn-inverse"><%= obj.total_books %></a></td>
    <td>
        <div class="btn-group">
            <button class="btn btn-info" onclick="editBook(<%= obj.book_id %>, this)" data-status="approved"
                data-table="new-table">Edit</button>
            <button class="btn btn-danger" onclick="deleteBook(<%= obj.book_id %>, this)" data-status="rejected"
                data-table="new-table">Delete</button>
        </div>

    </td>
</tr>
