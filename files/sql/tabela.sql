--
-- PostgreSQL database dump
--

-- Dumped from database version 12.3
-- Dumped by pg_dump version 12.3

-- Started on 2020-07-30 12:38:12

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 233 (class 1259 OID 17110)
-- Name: ufc_tipo_solu; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.ufc_tipo_solu (
    id integer NOT NULL,
    nome character varying(150),
    solucao text,
    problema text
);


ALTER TABLE public.ufc_tipo_solu OWNER TO postgres;

--
-- TOC entry 2919 (class 0 OID 17110)
-- Dependencies: 233
-- Data for Name: ufc_tipo_solu; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.ufc_tipo_solu (id, nome, solucao, problema) VALUES (1, 'Matricula Não anexada', 'O aluno deve anexar  o PDF do atestado de matrícula', '<p><br></p><table class="table table-bordered"><tbody><tr style="color:white; background-color: blue"><td>PENDÊNCIA</td></tr><tr><td><font color="#000000"><b>Matrícula </b>não anexada.</font></td></tr></tbody></table><p><br></p>');


--
-- TOC entry 2792 (class 2606 OID 17117)
-- Name: ufc_tipo_solu ufc_tipo_solu_pkey; Type: CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY public.ufc_tipo_solu
    ADD CONSTRAINT ufc_tipo_solu_pkey PRIMARY KEY (id);


-- Completed on 2020-07-30 12:38:13

--
-- PostgreSQL database dump complete
--

