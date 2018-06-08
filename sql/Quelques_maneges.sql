INSERT INTO public.manege VALUES (1, 'Licornator', 50, '00:05:00', '05:00:00', '19:00:00', 1, 'Femmes enceintes interdites');
INSERT INTO public.manege VALUES (4, 'Féérie nocturne', 700, '00:35:00', '21:25:00', '22:00:00', 8, 'Plein air. Tout public');
INSERT INTO public.manege VALUES (5, 'Mon petit poney', 12, '00:35:00', '11:00:00', '02:00:00', 18, 'enfants uniquement');
INSERT INTO public.manege VALUES (2, 'Psychédélicorne', 12, '00:10:00', '23:30:00', '18:30:00', 2, 'Hauteur min. 1m55');
INSERT INTO public.manege VALUES (3, 'Rainbow Ride', 20, '00:12:00', '09:00:00', '11:36:00', 3, 'Tout public');
SELECT pg_catalog.setval('public.manege_id_seq', 5, true);