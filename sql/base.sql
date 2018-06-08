--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.8
-- Dumped by pg_dump version 9.6.8

-- Started on 2018-06-07 15:35:12 CEST

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 2212 (class 1262 OID 16602)
-- Name: resaparc; Type: DATABASE; Schema: -; Owner: resaparc
--

CREATE DATABASE resaparc WITH TEMPLATE = template0 ENCODING = 'UTF8' LC_COLLATE = 'fr_FR.UTF-8' LC_CTYPE = 'fr_FR.UTF-8';


ALTER DATABASE resaparc OWNER TO resaparc;

\connect resaparc

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 1 (class 3079 OID 12437)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2214 (class 0 OID 0)
-- Dependencies: 1
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


--
-- TOC entry 192 (class 1255 OID 16659)
-- Name: calculer_prochain_horaire(integer, timestamp without time zone); Type: FUNCTION; Schema: public; Owner: resaparc
--

CREATE FUNCTION public.calculer_prochain_horaire(integer, timestamp without time zone) RETURNS timestamp without time zone
    LANGUAGE sql STABLE STRICT
    AS $_$
SELECT
	CASE
		WHEN $2 + manege.duree < $2::date + manege.heure_fermeture THEN $2 + manege.duree
		WHEN $2 + manege.duree < $2::date + manege.heure_ouverture THEN $2::date + manege.heure_ouverture
		ELSE $2::date + '1 day'::interval + manege.heure_ouverture
	END
 FROM manege
 WHERE manege.id = $1;$_$;


ALTER FUNCTION public.calculer_prochain_horaire(integer, timestamp without time zone) OWNER TO resaparc;

--
-- TOC entry 207 (class 1255 OID 16671)
-- Name: compter_reservations(character); Type: FUNCTION; Schema: public; Owner: resaparc
--

CREATE FUNCTION public.compter_reservations(character) RETURNS bigint
    LANGUAGE sql STRICT
    AS $_$SELECT COUNT(*) FROM reservation WHERE numero_billet = $1 AND horaire > now();$_$;


ALTER FUNCTION public.compter_reservations(character) OWNER TO resaparc;

--
-- TOC entry 194 (class 1255 OID 16687)
-- Name: modulo_intervals(interval, interval); Type: FUNCTION; Schema: public; Owner: resaparc
--

CREATE FUNCTION public.modulo_intervals(interval, interval) RETURNS interval
    LANGUAGE sql
    AS $_$SELECT (extract('epoch' FROM $1)::int % extract('epoch' FROM $2)::int || ' seconds')::interval;$_$;


ALTER FUNCTION public.modulo_intervals(interval, interval) OWNER TO resaparc;

--
-- TOC entry 191 (class 1255 OID 16679)
-- Name: reserver_prochain_horaire(integer, timestamp without time zone, character); Type: FUNCTION; Schema: public; Owner: resaparc
--

CREATE FUNCTION public.reserver_prochain_horaire(integer, timestamp without time zone, character) RETURNS void
    LANGUAGE sql STRICT
    AS $_$INSERT INTO reservation (id_manege, horaire, numero_billet) VALUES ($1, $2, $3);$_$;


ALTER FUNCTION public.reserver_prochain_horaire(integer, timestamp without time zone, character) OWNER TO resaparc;

--
-- TOC entry 208 (class 1255 OID 16680)
-- Name: reserver_prochain_horaire_disponible(integer, timestamp without time zone, character); Type: FUNCTION; Schema: public; Owner: resaparc
--

CREATE FUNCTION public.reserver_prochain_horaire_disponible(integer, timestamp without time zone, character) RETURNS void
    LANGUAGE sql STRICT
    AS $_$
SELECT
	CASE
		WHEN NOT reste_place($1, $2) OR ($3, $2) IN (
			SELECT DISTINCT numero_billet, horaire
			FROM reservation
			WHERE id_manege = $1
		) THEN reserver_prochain_horaire_disponible($1, calculer_prochain_horaire($1, $2), $3)
		ELSE reserver_prochain_horaire($1, $2, $3)
	END;$_$;


ALTER FUNCTION public.reserver_prochain_horaire_disponible(integer, timestamp without time zone, character) OWNER TO resaparc;

--
-- TOC entry 209 (class 1255 OID 16681)
-- Name: reserver_prochain_tour(integer, character); Type: FUNCTION; Schema: public; Owner: resaparc
--

CREATE FUNCTION public.reserver_prochain_tour(integer, character) RETURNS void
    LANGUAGE sql STRICT
    AS $_$SELECT reserver_prochain_horaire_disponible($1, prochain_tour, $2) FROM vue_prochain_tour WHERE id = $1;$_$;


ALTER FUNCTION public.reserver_prochain_tour(integer, character) OWNER TO resaparc;

--
-- TOC entry 193 (class 1255 OID 16662)
-- Name: reste_place(integer, timestamp without time zone); Type: FUNCTION; Schema: public; Owner: resaparc
--

CREATE FUNCTION public.reste_place(integer, timestamp without time zone) RETURNS boolean
    LANGUAGE sql STRICT
    AS $_$
SELECT COALESCE(COUNT(*) < manege.nb_places_reservables, true)
FROM manege
LEFT JOIN (
	SELECT *
	FROM reservation
	WHERE horaire = $2 AND id_manege = $1
) reservation_a_cet_horaire ON reservation_a_cet_horaire.id_manege = manege.id
WHERE manege.id = $1
GROUP BY manege.nb_places_reservables;$_$;


ALTER FUNCTION public.reste_place(integer, timestamp without time zone) OWNER TO resaparc;

--
-- TOC entry 1360 (class 2617 OID 16688)
-- Name: %; Type: OPERATOR; Schema: public; Owner: resaparc
--

CREATE OPERATOR public.% (
    PROCEDURE = public.modulo_intervals,
    LEFTARG = interval,
    RIGHTARG = interval
);


ALTER OPERATOR public.% (interval, interval) OWNER TO resaparc;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 186 (class 1259 OID 16605)
-- Name: manege; Type: TABLE; Schema: public; Owner: resaparc
--

CREATE TABLE public.manege (
    id integer NOT NULL,
    nom character varying(50) NOT NULL,
    nb_places_reservables integer NOT NULL,
    duree interval NOT NULL,
    heure_ouverture time without time zone NOT NULL,
    heure_fermeture time without time zone NOT NULL,
    numero_plan integer,
    consignes text,
    CONSTRAINT manege_check CHECK ((heure_ouverture <> heure_fermeture)),
    CONSTRAINT manege_nb_places_reservables_check CHECK ((nb_places_reservables > 0))
);


ALTER TABLE public.manege OWNER TO resaparc;

--
-- TOC entry 185 (class 1259 OID 16603)
-- Name: manege_id_seq; Type: SEQUENCE; Schema: public; Owner: resaparc
--

CREATE SEQUENCE public.manege_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.manege_id_seq OWNER TO resaparc;

--
-- TOC entry 2215 (class 0 OID 0)
-- Dependencies: 185
-- Name: manege_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: resaparc
--

ALTER SEQUENCE public.manege_id_seq OWNED BY public.manege.id;


--
-- TOC entry 188 (class 1259 OID 16622)
-- Name: reservation; Type: TABLE; Schema: public; Owner: resaparc
--

CREATE TABLE public.reservation (
    id integer NOT NULL,
    numero_billet character(14) NOT NULL,
    horaire timestamp without time zone NOT NULL,
    id_manege integer NOT NULL
);


ALTER TABLE public.reservation OWNER TO resaparc;

--
-- TOC entry 187 (class 1259 OID 16620)
-- Name: reservation_id_seq; Type: SEQUENCE; Schema: public; Owner: resaparc
--

CREATE SEQUENCE public.reservation_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE public.reservation_id_seq OWNER TO resaparc;

--
-- TOC entry 2216 (class 0 OID 0)
-- Dependencies: 187
-- Name: reservation_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: resaparc
--

ALTER SEQUENCE public.reservation_id_seq OWNED BY public.reservation.id;


--
-- TOC entry 190 (class 1259 OID 16689)
-- Name: vue_manege; Type: VIEW; Schema: public; Owner: resaparc
--

CREATE VIEW public.vue_manege AS
 SELECT manege.id,
    manege.nom,
    manege.nb_places_reservables,
    manege.duree,
    manege.heure_ouverture,
    manege.heure_fermeture,
    manege.numero_plan,
    manege.consignes,
        CASE
            WHEN (((now() >= ((now())::date + manege.heure_ouverture)) AND (now() <= ((now())::date + manege.heure_fermeture))) OR (((now() >= (((now())::date - '1 day'::interval) + (manege.heure_ouverture)::interval)) AND (now() <= ((now())::date + manege.heure_fermeture))) AND (manege.heure_ouverture > manege.heure_fermeture)) OR (((now() >= ((now())::date + manege.heure_ouverture)) AND (now() <= (((now())::date + '1 day'::interval) + (manege.heure_fermeture)::interval))) AND (manege.heure_ouverture > manege.heure_fermeture))) THEN ((((((now())::date + '1 day'::interval) + (manege.heure_fermeture)::interval))::timestamp with time zone - now()) OPERATOR(public.%) '1 day'::interval)
            ELSE '00:00:00'::interval
        END AS fermeture_dans
   FROM public.manege;


ALTER TABLE public.vue_manege OWNER TO resaparc;

--
-- TOC entry 189 (class 1259 OID 16673)
-- Name: vue_prochain_tour; Type: VIEW; Schema: public; Owner: resaparc
--

CREATE VIEW public.vue_prochain_tour AS
 WITH m AS (
         SELECT manege.id,
            manege.heure_ouverture,
            manege.heure_fermeture,
            manege.duree,
            (ceil((date_part('epoch'::text, (date_trunc('minute'::text, now()) - ((('now'::text)::date + manege.heure_ouverture))::timestamp with time zone)) / date_part('epoch'::text, manege.duree))) + (1)::double precision) AS nbtours
           FROM public.manege
        )
 SELECT m.id,
        CASE
            WHEN ((m.nbtours >= (0)::double precision) AND (((('now'::text)::date + m.heure_ouverture) + (m.nbtours * m.duree)) < ((now())::date + m.heure_fermeture))) THEN ((('now'::text)::date + m.heure_ouverture) + (m.nbtours * m.duree))
            WHEN (now() < ((now())::date + m.heure_ouverture)) THEN (('now'::text)::date + m.heure_ouverture)
            ELSE ((('now'::text)::date + '1 day'::interval) + (m.heure_ouverture)::interval)
        END AS prochain_tour
   FROM m;


ALTER TABLE public.vue_prochain_tour OWNER TO resaparc;

--
-- TOC entry 2072 (class 2604 OID 16608)
-- Name: manege id; Type: DEFAULT; Schema: public; Owner: resaparc
--

ALTER TABLE ONLY public.manege ALTER COLUMN id SET DEFAULT nextval('public.manege_id_seq'::regclass);


--
-- TOC entry 2075 (class 2604 OID 16625)
-- Name: reservation id; Type: DEFAULT; Schema: public; Owner: resaparc
--

ALTER TABLE ONLY public.reservation ALTER COLUMN id SET DEFAULT nextval('public.reservation_id_seq'::regclass);


--
-- TOC entry 2077 (class 2606 OID 16617)
-- Name: manege manege_nom_key; Type: CONSTRAINT; Schema: public; Owner: resaparc
--

ALTER TABLE ONLY public.manege
    ADD CONSTRAINT manege_nom_key UNIQUE (nom);


--
-- TOC entry 2079 (class 2606 OID 16619)
-- Name: manege manege_numero_plan_key; Type: CONSTRAINT; Schema: public; Owner: resaparc
--

ALTER TABLE ONLY public.manege
    ADD CONSTRAINT manege_numero_plan_key UNIQUE (numero_plan);


--
-- TOC entry 2081 (class 2606 OID 16615)
-- Name: manege manege_pkey; Type: CONSTRAINT; Schema: public; Owner: resaparc
--

ALTER TABLE ONLY public.manege
    ADD CONSTRAINT manege_pkey PRIMARY KEY (id);


--
-- TOC entry 2083 (class 2606 OID 16629)
-- Name: reservation reservation_numero_billet_horaire_id_manege_key; Type: CONSTRAINT; Schema: public; Owner: resaparc
--

ALTER TABLE ONLY public.reservation
    ADD CONSTRAINT reservation_numero_billet_horaire_id_manege_key UNIQUE (numero_billet, horaire, id_manege);


--
-- TOC entry 2085 (class 2606 OID 16627)
-- Name: reservation reservation_pkey; Type: CONSTRAINT; Schema: public; Owner: resaparc
--

ALTER TABLE ONLY public.reservation
    ADD CONSTRAINT reservation_pkey PRIMARY KEY (id);


--
-- TOC entry 2205 (class 2618 OID 16682)
-- Name: reservation reservation_3_max; Type: RULE; Schema: public; Owner: resaparc
--

CREATE RULE reservation_3_max AS
    ON INSERT TO public.reservation
   WHERE (public.compter_reservations(new.numero_billet) > 2) DO INSTEAD NOTHING;


--
-- TOC entry 2086 (class 2606 OID 16630)
-- Name: reservation reservation_id_manege_fkey; Type: FK CONSTRAINT; Schema: public; Owner: resaparc
--

ALTER TABLE ONLY public.reservation
    ADD CONSTRAINT reservation_id_manege_fkey FOREIGN KEY (id_manege) REFERENCES public.manege(id);


-- Completed on 2018-06-07 15:35:12 CEST

--
-- PostgreSQL database dump complete
--

