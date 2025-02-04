<?php
include 'Database.php';
$sql = "SELECT * FROM rooms";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Management</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-light border-right" id="sidebar-wrapper">
            <div class="sidebar-heading">Room Management</div>
            <div class="list-group list-group-flush">
                <a href="#" class="list-group-item list-group-item-action bg-light">Room Management</a>
                <a href="#" class="list-group-item list-group-item-action bg-light">Reservation</a>
                <a href="#" class="list-group-item list-group-item-action bg-light">Reports</a>
                <a href="#" class="list-group-item list-group-item-action bg-light">Analytics</a>
            </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <h1 class="mt-4">Room Management</h1>
                <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#addRoomModal">Add Room</button>
                <table id="roomsTable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Room Name</th>
                            <th>Room Type</th>
                            <th>Capacity</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['room_name']; ?></td>
                                <td><?php echo $row['room_type']; ?></td>
                                <td><?php echo $row['capacity']; ?></td>
                                <td><?php echo $row['status']; ?></td>
                                <td>
                                    <button class="btn btn-sm btn-warning edit-room" data-id="<?php echo $row['id']; ?>">Edit</button>
                                    <button class="btn btn-sm btn-danger delete-room" data-id="<?php echo $row['id']; ?>">Delete</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Room Modal -->
    <div class="modal fade" id="addRoomModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Room</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="add_room.php" method="POST">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Room Name</label>
                            <input type="text" name="room_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Room Type</label>
                            <input type="text" name="room_type" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Capacity</label>
                            <input type="number" name="capacity" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control" required>
                                <option value="available">Available</option>
                                <option value="occupied">Occupied</option>
                                <option value="maintenance">Maintenance</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Room Modal -->
    <div class="modal fade" id="editRoomModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Room</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="edit_room.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="form-group">
                            <label>Room Name</label>
                            <input type="text" name="room_name" id="edit_room_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Room Type</label>
                            <input type="text" name="room_type" id="edit_room_type" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Capacity</label>
                            <input type="number" name="capacity" id="edit_capacity" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" id="edit_status" class="form-control" required>
                                <option value="available">Available</option>
                                <option value="occupied">Occupied</option>
                                <option value="maintenance">Maintenance</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Room Modal -->
    <div class="modal fade" id="deleteRoomModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Room</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="delete_room.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="delete_id">
                        <p>Are you sure you want to delete this room?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#roomsTable').DataTable();

            $('.edit-room').click(function() {
                var id = $(this).data('id');
                $.ajax({
                    url: 'get_room.php',
                    type: 'POST',
                    data: {id: id},
                    success: function(response) {
                        var room = JSON.parse(response);
                        $('#edit_id').val(room.id);
                        $('#edit_room_name').val(room.room_name);
                        $('#edit_room_type').val(room.room_type);
                        $('#edit_capacity').val(room.capacity);
                        $('#edit_status').val(room.status);
                        $('#editRoomModal').modal('show');
                    }
                });
            });

            $('.delete-room').click(function() {
                var id = $(this).data('id');
                $('#delete_id').val(id);
                $('#deleteRoomModal').modal('show');
            });
        });
    </script>
</body>
</html>