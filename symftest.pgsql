--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.4
-- Dumped by pg_dump version 9.6.4

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: app_user; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE app_user (
    id integer NOT NULL,
    fio character varying(255) DEFAULT NULL::character varying,
    login character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    password character varying(64) NOT NULL,
    confirmed boolean DEFAULT false NOT NULL,
    created timestamp(0) without time zone NOT NULL,
    registred timestamp(0) without time zone DEFAULT NULL::timestamp without time zone,
    banned boolean DEFAULT false NOT NULL,
    birthday date
);


ALTER TABLE app_user OWNER TO postgres;

--
-- Name: app_user_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE app_user_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE app_user_id_seq OWNER TO postgres;

--
-- Name: images; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE images (
    id integer NOT NULL,
    author_id integer NOT NULL,
    comment text NOT NULL,
    image character varying(255) NOT NULL
);


ALTER TABLE images OWNER TO postgres;

--
-- Name: images_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE images_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE images_id_seq OWNER TO postgres;

--
-- Name: roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE roles (
    id integer NOT NULL,
    role_name character varying(255) NOT NULL
);


ALTER TABLE roles OWNER TO postgres;

--
-- Name: roles_id_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE roles_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE roles_id_seq OWNER TO postgres;

--
-- Name: user_roles; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE user_roles (
    user_id integer NOT NULL,
    roles_id integer NOT NULL
);


ALTER TABLE user_roles OWNER TO postgres;

--
-- Data for Name: app_user; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY app_user (id, fio, login, email, password, confirmed, created, registred, banned, birthday) FROM stdin;
1	\N	admin	admin@mail.ru	$2y$13$JUmLfW7dL.H4FmT10B1oZu2JOjlJjSv7PDm6/ua/5BLnabyD0sjUu	t	2017-10-22 00:43:32	2017-10-22 00:46:09	f	1974-11-01
2	\N	oxxxymiron	oxxxymiron@mail.ru	$2y$13$7AlTwdVyXjlGfg.tTpE9IuGcty3ONAhb/cz3aQixMoIig7cMYML8e	t	2017-10-22 00:51:34	2017-10-22 02:44:29	f	\N
6	Колесников Алексей Юльевич	Mad	alex_maykop@yahoo.com	$2y$13$jL3RHUo77CaAGjfqp2CXKewzCzM0khJCxVQV8xUgUJ6/4okkXpUPC	t	2017-10-22 21:43:45	2017-10-22 21:44:01	f	1974-11-01
\.


--
-- Name: app_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('app_user_id_seq', 6, true);


--
-- Data for Name: images; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY images (id, author_id, comment, image) FROM stdin;
1	1	Пушкин 2015	706cd5ab09c5dbcb811dbe8768910fe0.jpeg
2	2	Питер 2017	bb84f433e115885f37b005369b4cb3be.jpeg
3	2	Лаго-Наки 2015	e5113cfa7b42625cbd96e1aafa0f60ed.jpeg
4	2	Лаго-Наки 2017	d1cf33204fe059c443cd1931eda0fe98.jpeg
9	6	Выборг, лето 2016	65beee473002da14bcc36d381c5c3928.jpeg
\.


--
-- Name: images_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('images_id_seq', 9, true);


--
-- Data for Name: roles; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY roles (id, role_name) FROM stdin;
1	ROLE_ADMIN
2	ROLE_USER
\.


--
-- Name: roles_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('roles_id_seq', 1, false);


--
-- Data for Name: user_roles; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY user_roles (user_id, roles_id) FROM stdin;
1	2
1	1
2	2
6	2
\.


--
-- Name: app_user app_user_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY app_user
    ADD CONSTRAINT app_user_pkey PRIMARY KEY (id);


--
-- Name: images images_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY images
    ADD CONSTRAINT images_pkey PRIMARY KEY (id);


--
-- Name: roles roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY roles
    ADD CONSTRAINT roles_pkey PRIMARY KEY (id);


--
-- Name: user_roles user_roles_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY user_roles
    ADD CONSTRAINT user_roles_pkey PRIMARY KEY (user_id, roles_id);


--
-- Name: idx_54fcd59f38c751c4; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_54fcd59f38c751c4 ON user_roles USING btree (roles_id);


--
-- Name: idx_54fcd59fa76ed395; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_54fcd59fa76ed395 ON user_roles USING btree (user_id);


--
-- Name: idx_e01fbe6af675f31b; Type: INDEX; Schema: public; Owner: postgres
--

CREATE INDEX idx_e01fbe6af675f31b ON images USING btree (author_id);


--
-- Name: uniq_88bdf3e9aa08cb10; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX uniq_88bdf3e9aa08cb10 ON app_user USING btree (login);


--
-- Name: uniq_88bdf3e9e7927c74; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX uniq_88bdf3e9e7927c74 ON app_user USING btree (email);


--
-- Name: uniq_b63e2ec7e09c0c92; Type: INDEX; Schema: public; Owner: postgres
--

CREATE UNIQUE INDEX uniq_b63e2ec7e09c0c92 ON roles USING btree (role_name);


--
-- Name: user_roles fk_54fcd59f38c751c4; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY user_roles
    ADD CONSTRAINT fk_54fcd59f38c751c4 FOREIGN KEY (roles_id) REFERENCES roles(id) ON DELETE CASCADE;


--
-- Name: user_roles fk_54fcd59fa76ed395; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY user_roles
    ADD CONSTRAINT fk_54fcd59fa76ed395 FOREIGN KEY (user_id) REFERENCES app_user(id) ON DELETE CASCADE;


--
-- Name: images fk_e01fbe6af675f31b; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY images
    ADD CONSTRAINT fk_e01fbe6af675f31b FOREIGN KEY (author_id) REFERENCES app_user(id);


--
-- PostgreSQL database dump complete
--

