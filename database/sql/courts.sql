
-- Insert courts data in the Agadir region (Souss-Massa) into the 'courts' table

INSERT INTO courts (name, user_id, location, category, isDefault, created_at, updated_at) VALUES
    ('Tribunal d\'Appel d\'Agadir', NULL, 'Agadir', 'appel', 1, NOW(), NOW()),
    ('Tribunal de Première Instance d\'Agadir', NULL, 'Agadir', 'première instance', 1, NOW(), NOW()),
    ('Tribunal de Commerce d\'Agadir', NULL, 'Agadir', 'appel de commerce', 1, NOW(), NOW()),
    ('Centre des Juges Résidents d\'Agadir', NULL, 'Agadir', 'Centres des juges résidents', 1, NOW(), NOW()),
    ('Tribunal Administratif d\'Agadir', NULL, 'Agadir', 'administratifs', 1, NOW(), NOW()),
    ('Tribunal de Commerce d\'Agadir', NULL, 'Agadir', 'commerciaux', 1, NOW(), NOW()),
    ('Tribunal de Commerce de Taroudant', NULL, 'Taroudant', 'appel de commerce', 1, NOW(), NOW()),
    ('Tribunal de Première Instance de Tiznit', NULL, 'Tiznit', 'première instance', 1, NOW(), NOW()),
    ('Tribunal de Commerce de Tiznit', NULL, 'Tiznit', 'commerciaux', 1, NOW(), NOW()),
    ('Centre des Juges Résidents de Tiznit', NULL, 'Tiznit', 'Centres des juges résidents', 1, NOW(), NOW()),
    ('Tribunal Administratif de Tiznit', NULL, 'Tiznit', 'administratifs', 1, NOW(), NOW()),
    ('Tribunal de Première Instance de Sidi Ifni', NULL, 'Sidi Ifni', 'première instance', 1, NOW(), NOW()),
    ('Tribunal de Commerce de Sidi Ifni', NULL, 'Sidi Ifni', 'commerciaux', 1, NOW(), NOW()),
    ('Tribunal de Première Instance de Biougra', NULL, 'Biougra', 'première instance', 1, NOW(), NOW()),
    ('Tribunal de Commerce de Biougra', NULL, 'Biougra', 'commerciaux', 1, NOW(), NOW()),
    ('Tribunal de Première Instance de Ouarzazate', NULL, 'Ouarzazate', 'première instance', 1, NOW(), NOW()),
    ('Tribunal de Commerce de Ouarzazate', NULL, 'Ouarzazate', 'commerciaux', 1, NOW(), NOW());

