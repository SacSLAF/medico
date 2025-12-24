<?php
$title = 'Add New User';
$showNavbar = true;
?>

<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <div class="mb-6">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="<?php echo BASE_URL; ?>dashboard" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <i class="fas fa-home mr-2"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400"></i>
                        <a href="<?php echo BASE_URL; ?>users/manage" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">Users</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400"></i>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Add New</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Add New User</h1>
        <p class="text-gray-600">Create a new user account in the system</p>
    </div>
    
    <!-- Error Message -->
    <?php if (isset($errors['general'])): ?>
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <?php echo htmlspecialchars($errors['general']); ?>
        </div>
    <?php endif; ?>
    
    <!-- User Form -->
    <div class="bg-white rounded-lg shadow">
        <form method="POST" action="<?php echo BASE_URL; ?>users/store" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Username -->
                    <div>
                        <label for="username" class="block text-sm font-medium text-gray-700 mb-1">
                            Username <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="username" name="username" required
                               value="<?php echo htmlspecialchars($data['username'] ?? ''); ?>"
                               class="w-full px-3 py-2 border <?php echo isset($errors['username']) ? 'border-red-300' : 'border-gray-300'; ?> rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <?php if (isset($errors['username'])): ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo htmlspecialchars($errors['username']); ?></p>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" id="email" name="email" required
                               value="<?php echo htmlspecialchars($data['email'] ?? ''); ?>"
                               class="w-full px-3 py-2 border <?php echo isset($errors['email']) ? 'border-red-300' : 'border-gray-300'; ?> rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <?php if (isset($errors['email'])): ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo htmlspecialchars($errors['email']); ?></p>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                            Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="password" name="password" required
                               class="w-full px-3 py-2 border <?php echo isset($errors['password']) ? 'border-red-300' : 'border-gray-300'; ?> rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <?php if (isset($errors['password'])): ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo htmlspecialchars($errors['password']); ?></p>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Confirm Password -->
                    <div>
                        <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">
                            Confirm Password <span class="text-red-500">*</span>
                        </label>
                        <input type="password" id="confirm_password" name="confirm_password" required
                               class="w-full px-3 py-2 border <?php echo isset($errors['confirm_password']) ? 'border-red-300' : 'border-gray-300'; ?> rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <?php if (isset($errors['confirm_password'])): ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo htmlspecialchars($errors['confirm_password']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- First Name -->
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">
                            First Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="first_name" name="first_name" required
                               value="<?php echo htmlspecialchars($data['first_name'] ?? ''); ?>"
                               class="w-full px-3 py-2 border <?php echo isset($errors['first_name']) ? 'border-red-300' : 'border-gray-300'; ?> rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <?php if (isset($errors['first_name'])): ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo htmlspecialchars($errors['first_name']); ?></p>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Last Name -->
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">
                            Last Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="last_name" name="last_name" required
                               value="<?php echo htmlspecialchars($data['last_name'] ?? ''); ?>"
                               class="w-full px-3 py-2 border <?php echo isset($errors['last_name']) ? 'border-red-300' : 'border-gray-300'; ?> rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                        <?php if (isset($errors['last_name'])): ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo htmlspecialchars($errors['last_name']); ?></p>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                            Phone Number
                        </label>
                        <input type="tel" id="phone" name="phone"
                               value="<?php echo htmlspecialchars($data['phone'] ?? ''); ?>"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    
                    <!-- Role -->
                    <div>
                        <label for="role_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Role <span class="text-red-500">*</span>
                        </label>
                        <select id="role_id" name="role_id" required
                                class="w-full px-3 py-2 border <?php echo isset($errors['role_id']) ? 'border-red-300' : 'border-gray-300'; ?> rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Select a role</option>
                            <?php foreach ($roles as $role): ?>
                            <option value="<?php echo $role['id']; ?>" 
                                    <?php echo (($data['role_id'] ?? 0) == $role['id']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($role['role_name']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (isset($errors['role_id'])): ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo htmlspecialchars($errors['role_id']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Additional Fields (shown based on role) -->
            <div id="doctor-fields" class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6 hidden">
                <!-- Specialization -->
                <div>
                    <label for="specialization" class="block text-sm font-medium text-gray-700 mb-1">
                        Specialization
                    </label>
                    <input type="text" id="specialization" name="specialization"
                           value="<?php echo htmlspecialchars($data['specialization'] ?? ''); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           placeholder="e.g., Cardiologist, Pediatrician">
                </div>
                
                <!-- License Number -->
                <div>
                    <label for="license_number" class="block text-sm font-medium text-gray-700 mb-1">
                        License Number
                    </label>
                    <input type="text" id="license_number" name="license_number"
                           value="<?php echo htmlspecialchars($data['license_number'] ?? ''); ?>"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Medical license number">
                </div>
            </div>
            
            <!-- Form Actions -->
            <div class="mt-8 pt-6 border-t flex justify-end space-x-3">
                <a href="<?php echo BASE_URL; ?>users/manage" 
                   class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-4 py-2 bg-blue-600 border border-transparent rounded-md text-sm font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <i class="fas fa-save mr-2"></i>Create User
                </button>
            </div>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
include '../views/layouts/main.php';
?>
<script>
// Show/hide doctor fields based on role selection
document.getElementById('role_id').addEventListener('change', function() {
    const doctorFields = document.getElementById('doctor-fields');
    const isDoctor = this.value == '2'; // Role ID 2 is Doctor
    
    if (isDoctor) {
        doctorFields.classList.remove('hidden');
        // Make fields required
        document.getElementById('specialization').required = true;
        document.getElementById('license_number').required = true;
    } else {
        doctorFields.classList.add('hidden');
        // Make fields optional
        document.getElementById('specialization').required = false;
        document.getElementById('license_number').required = false;
    }
});

// Trigger change event on page load if doctor is already selected
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role_id');
    if (roleSelect.value == '2') {
        roleSelect.dispatchEvent(new Event('change'));
    }
});
</script>