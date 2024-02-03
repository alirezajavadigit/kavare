<?php

return [
    '
    SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
    START TRANSACTION;
    SET time_zone = "+00:00";
    
    CREATE TABLE `users` (
      `id` bigint(20) UNSIGNED NOT NULL,
      `name` varchar(255) NOT NULL,
      `email` varchar(255) NOT NULL,
      `email_verified_at` timestamp NULL DEFAULT NULL,
      `password` varchar(255) NOT NULL,
      `remember_token` varchar(100) DEFAULT NULL,
      `created_at` timestamp NULL DEFAULT NULL,
      `updated_at` timestamp NULL DEFAULT NULL,
      `is_admin` tinyint(1) NOT NULL DEFAULT 0
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    
    
    ALTER TABLE `users`
      ADD PRIMARY KEY (`id`),
      ADD UNIQUE KEY `users_email_unique` (`email`);
    
    
    ALTER TABLE `users`
      MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
    COMMIT;
    '
];
