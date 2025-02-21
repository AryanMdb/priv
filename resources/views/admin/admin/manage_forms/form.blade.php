<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="title">Select Category</label>
            <select name="category_id" class="form-control">
                <option value="" class="form-label">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ isset($manage_form->category_id) && $category->id == $manage_form->category_id ? 'selected' : '' }}>{{ $category->title }}</option>
                @endforeach
        </select>
        </div>
    </div>
    <div class="col-md-6"></div>
    <div class="col-md-6">
        <h4>Form Fields</h4>
        <div class="form-group">
            <input type="checkbox" id="name" name="input_field[]" value= "name"
             {{ isset($manage_fields) && $manage_fields->input_field == 'name' ? 'checked' : '' }}>
            <label for="title">Title</label><br>
            <input type="checkbox" id="phone" name="input_field[]" value="phone" 
                {{ isset($manage_fields) && $manage_fields->input_field == 'phone' ? 'checked' : '' }}>
            <label for="phone">Phone</label><br>

            <input type="checkbox" id="location" name="input_field[]" value="location" 
                {{ isset($manage_fields) && $manage_fields->input_field == 'location' ? 'checked' : '' }}>
            <label for="location">Location</label><br>

            <input type="checkbox" id="description" name="input_field[]" value="description" 
                {{ isset($manage_fields) && $manage_fields->input_field == 'description' ? 'checked' : '' }}>
            <label for="description">Description</label><br>

            <input type="checkbox" id="address_to" name="input_field[]" value="address_to" 
                {{ isset($manage_fields) && $manage_fields->input_field == 'address_to' ? 'checked' : '' }}>
            <label for="address_to">Address To</label><br>

            <input type="checkbox" id="address_from" name="input_field[]" value="address_from" 
                {{ isset($manage_fields) && $manage_fields->input_field == 'address_from' ? 'checked' : '' }}>
            <label for="address_from">Address From</label><br>

            <input type="checkbox" id="property_address" name="input_field[]" value="property_address" 
                {{ isset($manage_fields) && $manage_fields->input_field == 'property_address' ? 'checked' : '' }}>
            <label for="property_address">Property Address</label><br>

            <input type="checkbox" id="property_details" name="input_field[]" value="property_details" 
                {{ isset($manage_fields) && $manage_fields->input_field == 'property_details' ? 'checked' : '' }}>
            <label for="property_details">Property Details</label><br>

            <input type="checkbox" id="expected_cost" name="input_field[]" value="expected_cost" 
                {{ isset($manage_fields) && $manage_fields->input_field == 'expected_cost' ? 'checked' : '' }}>
            <label for="expected_cost">Expected Cost</label><br>
        </div>
    </div>
    <div class="col-md-12">
        <button type="submit" class="btn btn-primary mr-2">Submit</button>
    </div>
</div>