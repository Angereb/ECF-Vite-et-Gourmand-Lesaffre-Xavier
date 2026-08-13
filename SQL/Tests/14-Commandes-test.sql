INSERT INTO commandes (adresse, datePrestation, heureLivraison, convive, facture, utilisateursId, menusId, statutsCommandeId)
VALUES ('2 impasse de là bas, 33150 CENON', '2026-07-13', '12:45:25', '4', '145,55', 1, 1, 1);

INSERT INTO commandes (adresse, datePrestation, heureLivraison, convive, facture, utilisateursId, menusId, statutsCommandeId)
VALUES ('2 impasse de là bas, 33150 CENON', '2026-07-13', '12:45:25', '4', '145,55', null, 1, 1);
-- Echec champ utilisateursId null

INSERT INTO commandes (adresse, datePrestation, heureLivraison, convive, facture, utilisateursId, menusId, statutsCommandeId)
VALUES ('2 impasse de là bas, 33150 CENON', '2026-07-13', null, '4', '145,55', 1, 1, 1);
-- Echec champ heureLivraison null