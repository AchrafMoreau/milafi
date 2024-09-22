

-- Insert judges data in the Agadir region (Souss-Massa) into the 'judges' table

INSERT INTO judges (name, user_id, contact_info, gender, court_id, isDefault, created_at, updated_at) VALUES
    ('Judge Ahmed El Bakkali',  NULL, '0650-000-001', 'Male', 1,  1, NOW(), NOW()),
    ('Judge Fatima Zahra El Ouardi',  NULL, '0650-000-002', 'Female', 2, 1,  NOW(), NOW()),
    ('Judge Mohamed Ait Laaroussi',  NULL, '0650-000-003', 'Male', 3, 1, NOW(), NOW()),
    ('Judge Zineb Bakkali',  NULL, '0650-000-004', 'Female', 4,  1, NOW(), NOW()),
    ('Judge Abdelaziz Benhaddou',  NULL, '0650-000-005', 'Male', 5, 1, NOW(), NOW()),
    ('Judge Salima Meknassi',  NULL, '0650-000-006', 'Female', 6, 1, NOW(), NOW()),
    ('Judge Youssef El Amrani',  NULL, '0650-000-007', 'Male', 7, 1, NOW(), NOW()),
    ('Judge Khadija Benkaddour',  NULL, '0650-000-008', 'Female', 8, 1, NOW(), NOW()),
    ('Judge Rachid Bouhaddou',  NULL, '0650-000-009', 'Male', 9, 1, NOW(), NOW()),
    ('Judge Asmae El Idrissi',  NULL, '0650-000-010', 'Female', 10, 1, NOW(), NOW());
