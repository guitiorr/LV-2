<div>
    <h1>Edit Engine</h1>

    <form method="POST" action="/engine/{{ $engine->code }}">
        @csrf
        @method('PUT')

        <label class="floating-label mb-6">
            <input type="number"
                   name="displacement"
                   placeholder="Displacement (cc)"
                   value="{{ old('displacement', $engine->displacement) }}"
                   class="input input-bordered @error('displacement') input-error @enderror"
                   required>
            <span>Displacement</span>
        </label>

        @error('displacement')
            <div class="label -mt-4 mb-2">
                <span class="label-text-alt text-error">{{ $message }}</span>
            </div>
        @enderror


        <label class="floating-label mb-6">
            <input type="number"
                   name="cylinder_count"
                   placeholder="Cylinder Count"
                   value="{{ old('cylinder_count', $engine->cylinder_count) }}"
                   class="input input-bordered @error('cylinder_count') input-error @enderror"
                   required>
            <span>Cylinder Count</span>
        </label>

        @error('cylinder_count')
            <div class="label -mt-4 mb-2">
                <span class="label-text-alt text-error">{{ $message }}</span>
            </div>
        @enderror

        <div class="form-control mt-8">
            <button type="submit" class="btn btn-primary btn-sm w-full">
                Update Engine
            </button>
        </div>
    </form>
</div>
