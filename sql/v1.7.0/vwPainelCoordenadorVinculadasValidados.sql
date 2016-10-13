-- =========================================================================================
-- Autor: Rômulo Menhô Barbosa
-- Data de Criacao: 19/04/2016
-- Descricao: Painel do Coordenador de Vinculada com projetos devolvidos pelo parecerista
--            para validacao.
-- =========================================================================================

IF OBJECT_ID ('vwPainelCoordenadorVinculadasValidados', 'V') IS NOT NULL
DROP VIEW vwPainelCoordenadorVinculadasValidados ;
GO

SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW dbo.vwPainelCoordenadorVinculadasValidados
AS
SELECT p.IdPRONAC, (p.AnoProjeto + p.Sequencial) AS NrProjeto, p.NomeProjeto,t.idProduto,r.Descricao AS Produto, 
       b.Area AS idArea, a.Descricao AS Area,b.Segmento as idSegmento,c.Descricao AS Segmento,      
       t.idDistribuirParecer,d.Descricao AS Parecerista, t.idOrgao, 
	   t.DtEnvio as DtEnvioMincVinculada,t.DtDistribuicao,t.DtDevolucao,
	   sac.dbo.fnQtdeDiasAnaliseParecerista(p.IdPRONAC,t.idProduto,0) AS TempoTotalAnalise,
	   sac.dbo.fnQtdeDiasAnaliseParecerista(p.IdPRONAC,t.idProduto,1) AS TempoParecerista,
	   sac.dbo.fnQtdeDiasAnaliseParecerista(p.IdPRONAC,t.idProduto,2) AS TempoDiligencia,
	   (SELECT COUNT(*) FROM tbDiligencia x3
	                    WHERE  x3.idTipoDiligencia = 124 AND x3.stEstado = 0 AND x3.stEnviado = 'S' AND x3.idProduto = b.idProduto AND x3.idPronac =  p.IdPRONAC) AS qtDiligenciaProduto, 
	   (SELECT SUM(x.Ocorrencia*x.Quantidade*x.ValorUnitario) FROM SAC.dbo.tbPlanilhaProjeto x WHERE p.IdPRONAC = x.idPRONAC and x.FonteRecurso = 109 and x.idProduto = t.idProduto) AS Valor,
	   CAST(t.Observacao AS TEXT) AS Obs,t.stPrincipal,t.FecharAnalise,e.usu_nome as TecnicoValidador,t.DtRetorno as dtValidacao  
FROM tbDistribuirParecer            AS t
INNER JOIN Projetos                 AS p ON t.idPRONAC            = p.IdPRONAC
INNER JOIN PlanoDistribuicaoProduto AS b ON p.idProjeto           = b.idProjeto and t.idProduto = b.idProduto
INNER JOIN Produto                  AS r ON b.idProduto           = r.Codigo
INNER JOIN Area                     AS a ON b.Area                = a.Codigo 
INNER JOIN Segmento                 AS c ON b.Segmento            = c.Codigo 
INNER JOIN Agentes.dbo.Nomes        AS d ON t.idAgenteParecerista = d.idAgente
INNER JOIN Tabelas.dbo.Usuarios     AS e ON t.idUsuario           = e.usu_codigo
WHERE t.stEstado = 0 
      AND t.FecharAnalise= 3
      AND t.tipoanalise IN (3, 1) 
	  AND p.Situacao IN ('B11','B14') 
	  AND t.idAgenteParecerista IS NOT NULL
	  AND t.DtDistribuicao      IS NOT NULL
	  AND t.DtDevolucao         IS NOT NULL
GO 

GRANT  SELECT ON dbo.vwPainelCoordenadorVinculadasValidados  TO usuarios_internet
GO
