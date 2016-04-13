.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt


.. _appendix-a:

Appendix A: PHP classes migration
=================================

The table below gives a complete overview of how classes
were renamed when the whole Tesseract project was moved
to namespaces. It covers the "tesseract" extension itself
and all common components.

================= ========================================================== ======================================================================
Extension         Old class                                                  New class
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
context           tx_context                                                 \\Cobweb\\Context\\ContextLoader
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
context           tx_context_ContextStorage                                  \\Cobweb\\Context\\ContextStorageInterface
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
datafilter        tx_datafilter                                              \\Tesseract\\Datafilter\\Component\\DataFilter
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
datafilter        tx_datafilter_postprocessEmptyFilterCheck                  \\Tesseract\\Datafilter\\PostprocessEmptyFilterCheckInterface
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
datafilter        tx_datafilter_postprocessFilter                            \\Tesseract\\Datafilter\\PostprocessFilterInterface
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
dataquery         tx_dataquery_ajax                                          \\Tesseract\\Dataquery\\Ajax\\AjaxHandler
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
dataquery         tx_dataquery_cache                                         \\Tesseract\\Dataquery\\Cache\\CacheHandler
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
dataquery         tx_dataquery_cacheParametersProcessor                      \\Tesseract\\Dataquery\\Cache\\CacheParametersProcessorInterface
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
dataquery         tx_dataquery_wrapper                                       \\Tesseract\\Dataquery\\Component\\DataProvider
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
dataquery         tx_dataquery_datafilterhook                                \\Tesseract\\Dataquery\\Hook\\DataFilterHook
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
dataquery         Tx_Dataquery_Parser_Fulltext                               \\Tesseract\\Dataquery\\Parser\\FulltextParser
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
dataquery         tx_dataquery_parser                                        \\Tesseract\\Dataquery\\Parser\\QueryParser
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
dataquery         tx_dataquery_sqlparser                                     \\Tesseract\\Dataquery\\Parser\\SqlParser
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
dataquery         Tx_Dataquery_Userfunc_FormEngine                           \\Tesseract\\Dataquery\\UserFunction\\FormEngine
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
dataquery         Tx_Dataquery_Utility_DatabaseAnalyser                      \\Tesseract\\Dataquery\\Utility\\DatabaseAnalyser
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
dataquery         tx_dataquery_queryobject                                   \\Tesseract\\Dataquery\\Utility\\QueryObject
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
dataquery         tx_dataquery_sqlutility                                    \\Tesseract\\Dataquery\\Utility\\SqlUtility
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
dataquery         tx_dataquery_wizards_check                                 \\Tesseract\\Dataquery\\Wizard\\QueryCheckWizard
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
displaycontroller tx_displaycontroller                                       \\Tesseract\\Displaycontroller\\Controller\\DisplayController
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
displaycontroller tx_displaycontroller_pi1                                   \\Tesseract\\Displaycontroller\\Controller\\PluginCached
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
displaycontroller tx_displaycontroller_pi2                                   \\Tesseract\\Displaycontroller\\Controller\\PluginNotCached
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
displaycontroller tx_displaycontroller_hooks_tcemain                         \\Tesseract\\Displaycontroller\\Hook\\DataHandlerHook
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
displaycontroller tx_displaycontroller_service                               \\Tesseract\\Displaycontroller\\Service\\ControllerService
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
displaycontroller tx_displaycontroller_debugger                              \\Tesseract\\Displaycontroller\\Utility\\Debugger
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
displaycontroller tx_displaycontroller_realurl                               \\Tesseract\\Displaycontroller\\Utility\\RealUrlTranslator
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
displaycontroller tx_displaycontroller_pi1_wizicon                           \\Tesseract\\Displaycontroller\\Controller\\PluginCachedWizard
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
displaycontroller tx_displaycontroller_pi2_wizicon                           \\Tesseract\\Displaycontroller\\Controller\\PluginNotCachedWizard
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
expressions       Tx_Expressions_ViewHelpers_EvaluateViewHelper              \\Cobweb\\Expressions\\ViewHelpers\\EvaluateViewHelper
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
expressions       tx_expressions_parser                                      \\Cobweb\\Expressions\\ExpressionParser
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
expressions       tx_expressions_keyProcessor                                \\Cobweb\\Expressions\\KeyProcessorInterface
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
expressions       tx_expressions_valuePostProcessor                          \\Cobweb\\Expressions\\ValuePostProcessorInterface
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
fluiddisplay      tx_fluiddisplay                                            \\Tesseract\\Fluiddisplay\\Component\\DataConsumer
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
fluiddisplay      Tx_Fluiddisplay_ViewHelpers_SubstitutePageTitleViewHelper  \\Tesseract\\Fluiddisplay\\ViewHelpers\\SubstitutePageTitleViewHelper
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
overlays          tx_overlays                                                \\Cobweb\\Overlays\\OverlayEngine
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
templatedisplay   tx_templatedisplay                                         \\Tesseract\\Templatedisplay\\Component\\DataConsumer
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
templatedisplay   tx_templatedisplay_ajax                                    \\Tesseract\\Templatedisplay\\Ajax\\AjaxHandler
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
templatedisplay   tx_templatedisplay_CustomType                              \\Tesseract\\Templatedisplay\\RenderingType\\CustomTypeInterface
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
templatedisplay   tx_templatedisplay_PhoneType                               \\Tesseract\\Templatedisplay\\RenderingType\\PhoneType
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
templatedisplay   tx_templatedisplay_hook                                    \\Tesseract\\Templatedisplay\\Sample\\SampleHook
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
templatedisplay   \\Tesseract\\Templatedisplay\\Service\\SoftReferenceParser \\Tesseract\\Templatedisplay\\Service\\SoftReferenceParser
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
templatedisplay   tx_templatedisplay_tceforms                                \\Tesseract\\Templatedisplay\\UserFunction\\CustomFormEngine
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
tesseract         tx_tesseract                                               \\Tesseract\\Tesseract\\Tesseract
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
tesseract         tx_tesseract_dataconsumer                                  \\Tesseract\\Tesseract\\Component\\DataConsumerInterface
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
tesseract         tx_tesseract_datacontroller                                \\Tesseract\\Tesseract\\Component\\DataControllerInterface
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
tesseract         tx_tesseract_datacontroller_output                         \\Tesseract\\Tesseract\\Component\\DataControllerOutputInterface
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
tesseract         tx_tesseract_datafilter                                    \\Tesseract\\Tesseract\\Component\\DataFilterInterface
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
tesseract         tx_tesseract_dataprovider                                  \\Tesseract\\Tesseract\\Component\\DataProviderInterface
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
tesseract         tx_tesseract_exception                                     \\Tesseract\\Tesseract\\Exception\\Exception
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
tesseract         tx_tesseract_picontrollerbase                              \\Tesseract\\Tesseract\\Frontend\\PluginControllerBase
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
tesseract         tx_tesseract_component                                     \\Tesseract\\Tesseract\\Service\\Component
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
tesseract         tx_tesseract_consumerbase                                  \\Tesseract\\Tesseract\\Service\\ConsumerBase
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
tesseract         tx_tesseract_controllerbase                                \\Tesseract\\Tesseract\\Service\\ControllerBase
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
tesseract         tx_tesseract_feconsumerbase                                \\Tesseract\\Tesseract\\Service\\FilterBase
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
tesseract         tx_tesseract_filterbase                                    \\Tesseract\\Tesseract\\Service\\FrontendConsumerBase
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
tesseract         tx_tesseract_providerbase                                  \\Tesseract\\Tesseract\\Service\\ProviderBase
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
tesseract         tx_tesseract_emconfhelper                                  \\Tesseract\\Tesseract\\Utility\\ExtensionManagerConfigurationHelper
----------------- ---------------------------------------------------------- ----------------------------------------------------------------------
tesseract         tx_tesseract_utilities                                     \\Tesseract\\Tesseract\\Utility\\Utilities
================= ========================================================== ======================================================================
