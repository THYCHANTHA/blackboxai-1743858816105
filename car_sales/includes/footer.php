</main>

    <!-- Tesla-inspired footer -->
    <footer class="bg-black text-white py-12">
        <div class="container mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div>
                    <h3 class="text-xl font-bold mb-4">ELITE MOTORS</h3>
                    <p class="text-gray-400">Premium vehicles for discerning buyers. Experience luxury redefined.</p>
                    <div class="flex space-x-4 mt-4">
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="<?php echo SITE_URL; ?>/cars.php" class="text-gray-400 hover:text-white">Inventory</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/index.php#features" class="text-gray-400 hover:text-white">Features</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/index.php#testimonials" class="text-gray-400 hover:text-white">Testimonials</a></li>
                        <li><a href="<?php echo SITE_URL; ?>/contact.php" class="text-gray-400 hover:text-white">Contact</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h4 class="font-semibold mb-4">Contact Us</h4>
                    <ul class="space-y-2">
                        <li class="flex items-center text-gray-400"><i class="fas fa-map-marker-alt mr-2"></i> 123 Auto Blvd, Motor City</li>
                        <li class="flex items-center text-gray-400"><i class="fas fa-phone-alt mr-2"></i> (555) 123-4567</li>
                        <li class="flex items-center text-gray-400"><i class="fas fa-envelope mr-2"></i> info@elitemotors.com</li>
                    </ul>
                </div>

                <!-- Newsletter -->
                <div>
                    <h4 class="font-semibold mb-4">Newsletter</h4>
                    <p class="text-gray-400 mb-4">Subscribe for updates on new arrivals and special offers.</p>
                    <form class="flex">
                        <input type="email" placeholder="Your email" class="px-4 py-2 w-full text-gray-900">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 px-4 py-2">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&amp;copy; <?php echo date('Y'); ?> ELITE MOTORS. All rights reserved.</p>
                <div class="flex justify-center space-x-4 mt-4">
                    <a href="#" class="hover:text-white">Privacy Policy</a>
                    <a href="#" class="hover:text-white">Terms of Service</a>
                    <a href="#" class="hover:text-white">Legal</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.0.0/dist/cdn.min.js" defer></script>
    <?php if(isset($scripts)): ?>
        <?php foreach($scripts as $script): ?>
            <script src="<?php echo $script; ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>