<?php

namespace Comments\Options;

use Zend\Stdlib\AbstractOptions;

/**
 * Description of CommentOptions
 *@todo review posibility of mering with general config
 *@todo pretty sure the abstract class uses classmethods to hydrate from array
 * @author gerard
 */
class CommentOptions extends AbstractOptions 
{

    /**
     *the user entity class name
     * @var string
     */
    protected $userEntityClassName;
    /**
     *the module entity class name
     * @var string
     */
    protected $moduleEntityClass;
     /**
     *the comment entity class name
     * @var string
     */
    protected $commentEntityClass;
    /**
     *the tag enity class name
     * @var string
     */
    protected $tagEntityClass;
    /**
     *should be in a data directory 
     * @var string
     */
    protected $moduleIndexPath;
    /**
     * don't know about this
     *@todo find out about this
     *@deprecated since version 1
     * @var string
     */
    protected $viewExceptionTemplateName;
   

    /**
     * the class to be instanciated for comments 
     * @param string $className
     * @return \Comments\Options\CommentOptions
     */
    public function setCommentEntityClassName($className)
    {
        $this->commentEntityClass=$className;
        
        return $this;
    }
    /**
     * the class to be instanciated for  users
     * @return string
     */
    public function getUserEntityClassName()
    {
        return $this->userEntityClassName;
    }
    /**
     * the class to be instanciated for users
     * @param string $className
     * @return \Comments\Options\CommentOptions
     */
    public function setUserEntityClassName($className)
    {
         $this->userEntityClassName=$className;
         
         return $this;
    }
    

    /**
     * the class to be instanciated for comments
     * @return string
     */
    public function getCommentEntityClassName()
    {
        return $this->commentEntityClass;
    }
    /**
     * todo-remove
     * the class to be instanciated for comments
     * @param string $className
     * @return \Comments\Options\CommentOptions
     */
    public function setModuleEntityClass($className) 
    {
        $this->moduleEntityClass = $className;
        return $this;
    }
    /**
     * the class to be instanciated for modules
     * @return string
     */
    public function getModuleEntityClass() 
    {
        return $this->moduleEntityClass = $string;
    }
    /**
     * the template to be used to render exceptions
     * @return string
     */
    public function getViewExceptionTemplateName()
    {
        return $this->viewExceptionTemplateName;
    }
    /**
     * the template to be used to render exceptions
     * @param string $templateName
     * @return \Comments\Options\CommentOptions
     */
    public function setViewExceptionTemplateName($templateName)
    {
        $this->viewExceptionTemplateName = $templateName;
        
        return $this;
    }
    /**
      * the class to be instanciated for tag entities 
     * @param string $string
     * @return \Comments\Options\CommentOptions
     */
    public function setTagEntityClassName($className) 
    {
        $this->tagEntityClass = $className;
        return $this;
    }
    /**
      * the class to be instanciated for tag entities 
     * @return string
     */
    public function getTagEntityClassName() 
    {
        return $this->tagEntityClass = $string;
    }

   
}
