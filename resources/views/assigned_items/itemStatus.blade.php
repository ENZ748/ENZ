<h1>Item Status</h1>
                        <form action="{{ route('assigned_items.good', $assignedItem->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-success">Good</button>
                        </form>

                        <form action="{{ route('assigned_items.damaged', $assignedItem->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('POST')
                            <button type="submit" class="btn btn-success">Damaged</button>
                        </form>
