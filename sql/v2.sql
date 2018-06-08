CREATE OR REPLACE FUNCTION public.division_intervals(
    interval,
    interval)
  RETURNS double precision AS
$BODY$SELECT extract('epoch' FROM $1) / extract('epoch' FROM $2);$BODY$
  LANGUAGE sql IMMUTABLE
  COST 100;
ALTER FUNCTION public.division_intervals(interval, interval)
  OWNER TO resaparc;

CREATE OPERATOR public./(
  PROCEDURE = division_intervals,
  LEFTARG = interval,
  RIGHTARG = interval);

DROP FUNCTION public.calculer_prochain_horaire(integer, timestamp without time zone);

CREATE OR REPLACE FUNCTION public.calculer_prochain_horaire(
    integer,
    timestamp without time zone)
  RETURNS timestamp without time zone AS
$BODY$
WITH m AS (
	SELECT
		manege.id,
		CASE WHEN manege.heure_ouverture > $2::time THEN $2::date + manege.heure_ouverture
		ELSE $2::date + '1 day'::interval + manege.heure_ouverture END prochaine_ouverture,
		CASE WHEN manege.heure_fermeture < $2::time THEN $2::date + '1 day'::interval + manege.heure_fermeture
		ELSE $2::date + manege.heure_fermeture END fermeture
	FROM manege
	WHERE manege.id = $1
)
SELECT
	CASE
		WHEN $2 + manege.duree < m.fermeture THEN $2 + manege.duree
		ELSE m.prochaine_ouverture
	END
 FROM manege
 JOIN m ON m.id = manege.id; -- tri déjà fait, il n'y a qu'une ligne dans m
 $BODY$
  LANGUAGE sql STABLE STRICT
  COST 100;
ALTER FUNCTION public.calculer_prochain_horaire(integer, timestamp without time zone)
  OWNER TO resaparc;

DROP FUNCTION public.reserver_prochain_horaire_disponible(integer, timestamp without time zone, character);

CREATE OR REPLACE FUNCTION public.reserver_prochain_horaire_disponible(
    integer,
    timestamp without time zone,
    character)
  RETURNS void AS
$BODY$
SELECT
	CASE
		WHEN NOT reste_place($1, $2) OR $3 IN (
			SELECT DISTINCT numero_billet
			FROM reservation
			WHERE abs(extract('epoch' FROM $2 - horaire)) < 600
		) THEN reserver_prochain_horaire_disponible($1, calculer_prochain_horaire($1, $2), $3)
		ELSE reserver_prochain_horaire($1, $2, $3)
	END;$BODY$
  LANGUAGE sql VOLATILE STRICT
  COST 100;
ALTER FUNCTION public.reserver_prochain_horaire_disponible(integer, timestamp without time zone, character)
  OWNER TO resaparc;

DROP VIEW public.vue_prochain_tour;

CREATE OR REPLACE VIEW public.vue_prochain_tour AS 
 SELECT manege.id,
        CASE
            WHEN ('now'::text::date + manege.heure_ouverture) < now() THEN
            CASE
                WHEN ('now'::text::date + manege.heure_fermeture) >= ('now'::text::date + manege.heure_ouverture) AND ('now'::text::date + manege.heure_fermeture) <= now() THEN 'now'::text::date + manege.heure_ouverture + '1 day'::interval
                ELSE 'now'::text::date + manege.heure_ouverture + (ceil((now() - ('now'::text::date + manege.heure_ouverture)::timestamp with time zone) / manege.duree) + 1::double precision) * manege.duree
            END
            ELSE
            CASE
                WHEN ('now'::text::date + manege.heure_fermeture) >= now() AND ('now'::text::date + manege.heure_fermeture) <= ('now'::text::date + manege.heure_ouverture) THEN 'now'::text::date + manege.heure_ouverture - '1 day'::interval + (ceil((now() - ('now'::text::date + manege.heure_ouverture)::timestamp with time zone + '1 day'::interval) / manege.duree) + 1::double precision) * manege.duree
                ELSE 'now'::text::date + manege.heure_ouverture
            END
        END AS prochain_tour
   FROM manege;

ALTER TABLE public.vue_prochain_tour
  OWNER TO resaparc;