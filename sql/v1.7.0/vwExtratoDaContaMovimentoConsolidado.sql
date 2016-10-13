-- ===========================================================================================
-- Autor: Rômulo Menhô Barbosa
-- Data de Criacao: 25/04/2016
-- Descricao: Extrato bancario da conta movimentacao consolidado.
-- ===========================================================================================

IF OBJECT_ID ('vwExtratoDaContaMovimentoConsolidado', 'V') IS NOT NULL
DROP VIEW vwExtratoDaContaMovimentoConsolidado ;
GO

SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW dbo.vwExtratoDaContaMovimentoConsolidado
AS
SELECT b.idPronac,b.AnoProjeto+b.Sequencial as Pronac,b.NomeProjeto,a.stContaLancamento,
       CASE
	     WHEN a.stContaLancamento = 0
		   THEN 'Captação'
		   ELSE 'Movimentação'
		 END AS TipoConta,
       a.nrAgenciaLancamento AS Agencia,a.nrContaLancamento AS NrConta,a.cdLancamento As Codigo,a.dsLancamento AS Lancamento,
       SUM(a.vlLancamento) AS vlLancamento,a.stLancamento	    
FROM SAC.DBO.tbLancamentoBancario  a 
INNER JOIN SAC.dbo.Projetos        b on (a.idPronac = b.IdPRONAC)
GROUP BY b.idPronac,b.AnoProjeto+b.Sequencial,b.NomeProjeto,a.stContaLancamento,
          a.nrAgenciaLancamento,a.nrContaLancamento,a.cdLancamento,a.dsLancamento,a.stLancamento

GO 

GRANT  SELECT ON dbo.vwExtratoDaContaMovimentoConsolidado  TO usuarios_internet
GO
