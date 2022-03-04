-- drop database
drop database mype_report;

--create database

create database mype_report;

--use database

use mype_report;

--create table

create table tb_usuario_administrador(
id_adm int not null auto_increment,
nome_adm varchar(100) not null,
username_adm varchar(50) not null unique,
email_adm varchar(75) not null unique,
email_adm_ctt varchar(75) not null unique,
telefone_adm char(14) not null unique,
telefone_adm_sub char(14) unique,
senha_adm varchar(100) not null,
primary key(id_adm));

create table tb_empresas(
id_emp int not null auto_increment,
cnpj_emp char(14) not null unique,
razao_social_emp varchar(50) not null unique,
nome_fantasia_emp varchar(50) not null unique,
logo_emp varchar(100) null,
cor_pri_emp varchar(6) null,
cor_sec_emp varchar(6) null,
endereco_emp varchar(150) not null,
situacao_emp char(7) not null check(situacao_emp = 'ativo' || situacao_emp = 'inativo'),
primary key(id_emp));

create table tb_departamentos(
id_dpto int not null auto_increment,
id_emp int not null,
nome_dpto varchar(75) not null,
centro_dcusto_dpto varchar(50),
primary key(id_dpto),
foreign key(id_emp) references tb_empresas(id_emp));

create table tb_relatorios(
id_rel int not null auto_increment,
id_emp int not null,
nome_rel varchar(50) not null,
link_rel varchar(300) not null,
situacao_rel char(7) not null check(situacao_rel = 'ativo' || situacao_rel = 'inativo'),
primary key(id_rel),
foreign key(id_emp) references tb_empresas(id_emp));

create table tb_usuarios(
id_usu int not null auto_increment,
id_emp int null,
id_dpto int null,
nome_usu varchar(100) not null,
username_usu varchar(50) not null unique,
email_usu varchar(75) not null unique,
telefone_usu char(14) not null unique,
perfil_usu char(3) not null check(perfil_usu = 'adm' || perfil_usu = 'usu'),
senha_usu varchar(100) not null,
situacao_usu char(7) not null check(situacao_usu = 'ativo' || situacao_usu = 'inativo'),
recupera_senha_usu varchar(100),
primary key(id_usu),
foreign key(id_emp) references tb_empresas(id_emp),
foreign key(id_dpto) references tb_departamentos(id_dpto));

create table tb_indicadores(
id_ind int not null auto_increment,
id_rel int not null,
id_usu int not null,
primary key(id_ind),
foreign key(id_rel) references tb_relatorios(id_rel),
foreign key(id_usu) references tb_usuarios(id_usu));
