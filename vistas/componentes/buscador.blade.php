<div class="container mt-4">
    <form action="{{ $actionUrl }}" method="POST" class="d-flex">
        <input class="form-control me-2" type="search" placeholder="{{ $placeholder }}" aria-label="Search" name="{{ $fieldName }}">
        <button class="btn btn-outline-success" type="submit" name="{{ $info }}">
            <i class="bi bi-search"></i>
        </button>
    </form>
</div>


