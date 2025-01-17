<?php

namespace App\AI;

use \Illuminate\Support\Facades\Http;

class ChatConsultant
{
    protected array $messages = [];
    protected $ENDPOINT_URL;
    protected $OPENAI_API_KEY;
    protected $DEPLOYMENT_NAME;
    protected $SEARCH_ENDPOINT;
    protected $SEARCH_KEY;
    protected $SEARCH_INDEX;
    protected $EMBEDDING_ENDPOINT;

    public function __construct()
    {
        $this->ENDPOINT_URL = config('services.azure.endpoint_url');
        $this->OPENAI_API_KEY = config('services.azure.openai_api_key');
        $this->DEPLOYMENT_NAME = config('services.azure.deployment_name');
        $this->SEARCH_ENDPOINT = config('services.azure.search_endpoint');
        $this->SEARCH_KEY = config('services.azure.search_key');
        $this->SEARCH_INDEX = config('services.azure.search_index');
        $this->EMBEDDING_ENDPOINT = config('services.azure.embedding_endpoint');
    }

    public function systemMessage(string $message): static
    {
        $this->messages[] = [
            'role' => 'system',
            'content' => $message
        ];

        return $this;
    }

    public function send(string $message)
    {
        $this->messages[] = [
            'role' => 'user',
            'content' => $message
        ];

        $messages = $this->messages;

        $apiEndpoint = $this->ENDPOINT_URL . "openai/deployments/" . $this->DEPLOYMENT_NAME . "/chat/completions?api-version=2024-02-15-preview";

        $roleInformation = "Análise de Viabilidade de Marca\n\nSolicitação de Entrada:\n- Nome da Marca: Solicite ao operador o nome da marca que será analisada.\n- Descrição da Empresa/Marca: Peça ao operador uma breve descrição da área de atuação da empresa e os produtos ou serviços oferecidos.\n\n\nAnálise Prévia de Disponibilidade:\n\nFaça uma pesquisa prévia nos seguintes bancos de dados e plataformas e forneça os resultados:\n\n- INPI (Instituto Nacional da Propriedade Industrial) – Verifique se o nome da marca está disponível ou se há marcas similares já registradas.\n- WIPO (World Intellectual Property Organization) – Verifique a disponibilidade global e a existência de marcas similares.\n- Domínios de Web – Verifique se o domínio correspondente ao nome da marca está disponível.\n- Redes Sociais – Verifique a disponibilidade de nomes de usuário em plataformas relevantes, como Instagram, Facebook e TikTok.\n\nAnálise de Exclusividade:\n\nBaseando-se nos dados fornecidos, avalie se a marca está disponível ou se há conflitos potenciais. Analise se há marcas similares no mesmo setor ou em áreas correlatas que possam gerar confusão.\n\nEstrutura da Tabela:\n\n- Nome: Nome da marca a ser analisada.\n- Score em Conformidade com o Padrão de Exclusividade: Pontuação percentual de 0 a 100% que reflete o grau de exclusividade.\n- Observação sobre a Conformidade: Explicação sobre a disponibilidade e os possíveis conflitos encontrados.\n\nAnálise de Viabilidade com base no Manual do INPI:\n\nUtilize o Manual do INPI como referência para avaliar a possibilidade de registro da marca, considerando critérios de distintividade e a ausência de colisão com marcas já registradas. Avalie a conformidade com os princípios legais de territorialidade e especialidade.\n\nUtilize o pdf Marcasindef  para aprender sobre os motivos de indeferimento do INPI. e utilizar estas decisões padrões para analise e possivel enquadramento.\n\nEstrutura da Tabela:\n\n- Nome: Nome da marca a ser analisada.\n- Score em Conformidade com o Manual do INPI: Pontuação percentual de 0 a 100% com base nos critérios do INPI.\n- Observação sobre a Conformidade: Explicação sobre a viabilidade jurídica e os obstáculos legais para o registro da marca.\n\nAnálise de Gestão de Risco com base na ISO 31000:\n\nAplique as diretrizes da ISO 31000 para avaliar os riscos associados ao uso da marca. Considere riscos legais (colisões com outras marcas), riscos reputacionais (confusão com marcas similares), e riscos operacionais (custos de rebranding, por exemplo).\n\nEstrutura da Tabela:\n\n- Nome: Nome da marca a ser analisada.\n- Score em Conformidade com a ISO 31000: Pontuação percentual de 0 a 100% refletindo o grau de conformidade com as diretrizes de gestão de riscos.\n- Observação sobre a Conformidade: Explicação sobre os principais riscos identificados e recomendações de mitigação.\n\nAnálise de Brand Fit:\n\nAvalie a adequação do nome da marca com sua proposta de valor, público-alvo e o setor em que atua. Considere como o nome da marca reflete seus valores e diferenciação no mercado.\n\nEstrutura da Tabela:\n\n- Nome: Nome da marca a ser analisada.\n- Score em Conformidade com Brand Fit: Pontuação percentual de 0 a 100% refletindo o grau de adequação ao mercado e à estratégia da empresa.\n- Observação sobre o Brand Fit: Explicação sobre o alinhamento do nome com a proposta de valor, clareza e diferenciação no mercado.\n\nConclusão e Recomendações:\n\nCom base nas análises acima, apresente uma conclusão objetiva sobre a viabilidade da marca e forneça recomendações claras e práticas. Considere opções de modificação do nome para garantir exclusividade, ou outras estratégias de mitigação de riscos.\nExemplo de Saída Esperada:\n\nRelatório de Viabilidade de Marca - 3PI\n\n- Análise de Exclusividade: Avaliação da originalidade da marca e seu potencial de exclusividade no mercado.\n- Análise de Viabilidade com base no INPI: Consideração sobre a possibilidade de registro legal da marca, com base nas normas do INPI.\n- Análise de Gestão de Risco com base na ISO 31000: Identificação de riscos associados ao uso da marca e recomendações de mitigação.\n- Análise de Brand Fit: Avaliação do ajuste da marca com o setor, público-alvo e proposta de valor.\n\nConclusão Geral: Resumo das análises e recomendações para o nome da marca.\n\nconsidere humanizar a saida e ao mesmo tempo apresentar de maneira tecnica e profissional de alto nivel\n\nfaca a saida em tabelas.\n\n- analise cada conceito de brandfit incluindo a explicacao de nota para cada conceito.\n- analise cada aspecto do manual de marcas do inpi no tocante a viabilidade de nome de marca  com nota e explicacao de cada um\n\ninclua fundamentacao legal com base no manual do inpi de sua base.\n- incluir maior grau de detalhamento de nivel alto\n- quero que analise todos elementos de brandfit: Conceito, Exclusividade, Adequação , Sonoridade, Longevidade e Memorização.\nfaca texto longo\n\nRecomendações de Mitigação:\n\n- Sugira planos de contingência e ações para reduzir impactos potenciais se os riscos forem significativos.\n- quero que inclua um aviso que este relatorio nao é aconselhamento legal ou garantia de deferimento ou indeferimento no INPI.\n- nao quero que recomende contratar um adv especializado ou consulta ao inpi\n- quero que recomende isto: enviar novo nome a analise ou entrar em contato com nossos consultores para contratar consultoria para apoio a criação do nome/logo\n- a saida deve ser feita em tabelas. a saida deve seguir a estrutura do pdf da base do agent\n- a saida deve ser de textos longos - cd explicacao da saida deve ser detalhada em nivel alto de leitura\n- a saida deve conter todos elementos que contém no pdf da base \"analise de viabilidade\"\nna saida utiliza Lógica de Álgebra Linear:\n\n- Utilize combinações lineares dos critérios e pesos para cálculos objetivos.\n- Fórmula geral: Score Final=∑(Peso do Criterio×Nota do Critério)Score Final=∑(Peso do Criteˊrio×Nota do Criteˊrio)\n- Assegura objetividade e consistência nas notas.\n\nExemplo do Cego no Penhasco:\n- Raciocínio Estruturado: Como um cego que usa uma bengala para evitar perigos, siga procedimentos definidos para evitar erros.\n- Evitar Decisões Arbitrárias: Não faça suposições sem fundamento; baseie-se nos critérios estabelecidos.\n- na saida inclua elemento legis do manual do inpi\n- gere um relatorio com base nas politicas de ux . nao inclua as formulas usadas por ser sigilo. a saida é um relatorio de p.i de leitura avancada e textos longos.";

        $additionalInfo = "Estruture a resposta em json, incluindo as tabelas, em formato json aninhado".

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'api-key' => $this->OPENAI_API_KEY,
        ])->post($apiEndpoint, [
            'messages' => $this->messages,
            "model" => "gpt-4o-mini",
            "max_tokens" => 16000,
            "temperature" => 0.7,
            "top_p" => 0.95,
            "frequency_penalty" => 0,
            "presence_penalty" => 0,
            "stop" => null,
            "stream" => false,
            "data_sources" => [
                [
                    "type" => "azure_search",
                    "parameters"=> [
                        "filter"=> null,
                        "endpoint"=> $this->SEARCH_ENDPOINT,
                        "index_name"=> $this->SEARCH_INDEX,
                        "semantic_configuration"=> "azureml-default",
                        "authentication"=> [
                            "type"=> "api_key",
                            "key"=> $this->SEARCH_KEY
                        ],
                        "embedding_dependency" => [
                            "type" => "endpoint",
                            "endpoint" => $this->EMBEDDING_ENDPOINT,
                            "authentication" => [
                                "type" => "api_key",
                                "key" => $this->OPENAI_API_KEY
                            ]
                        ],
                        "query_type" => "vector_simple_hybrid",
                        "in_scope" => true,
                        "role_information" => $roleInformation,
                        "strictness" => 3,
                        "top_n_documents" => 5,
                        "key" => $this->SEARCH_KEY,
                        "indexName" => $this->SEARCH_INDEX,
                    ]
                ],
            ]
        ]);

        if ($response) {
            $this->messages[] = [
                'role' => 'assistant',
                'content' => $response->json('choices.0.message.content')
            ];
        }

        return $response;
    }

    public function reply(string $message): ?string
    {
        return $this->send($message);
    }

    public function messages()
    {
        return $this->messages;
    }
}
