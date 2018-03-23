<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 20/03/2018
 * Time: 19:26
 */

namespace App\Service\Impl;


use App\Service\UserService;

class UserServiceImpl implements UserService
{

    public function getUser($id)
    {
        // TODO: Implement getUser() method.
    }

    public function getOpenid($id)
    {
        // TODO: Implement getOpenid() method.
    }

    public function getUserByHashid($hashid, $withPrivacy = true)
    {
        // TODO: Implement getUserByHashid() method.
    }

    public function getUserByUsername($username)
    {
        // TODO: Implement getUserByUsername() method.
    }

    public function getUserByNickname($nickname)
    {
        // TODO: Implement getUserByNickname() method.
    }

    public function getUserByWxUnionId($wid)
    {
        // TODO: Implement getUserByWxUnionId() method.
    }

    public function findUsersByIds($ids)
    {
        // TODO: Implement findUsersByIds() method.
    }

    public function findUsersByHashids($hashids)
    {
        // TODO: Implement findUsersByHashids() method.
    }

    public function register($user, $type)
    {
        // TODO: Implement register() method.
    }

    public function refreshFromWeixin($id, $user, $type)
    {
        // TODO: Implement refreshFromWeixin() method.
    }

    public function bindUser($bindId, $bindType, $userId)
    {
        // TODO: Implement bindUser() method.
    }

    public function switchUserIdentity($userId, $identity)
    {
        // TODO: Implement switchUserIdentity() method.
    }

    public function updateUser($id, $fields, $ignoreEmptyFields = true)
    {
        // TODO: Implement updateUser() method.
    }

    public function calcResumeProgress($id, $progress)
    {
        // TODO: Implement calcResumeProgress() method.
    }

    public function saveEdu($userId, $edu)
    {
        // TODO: Implement saveEdu() method.
    }

    public function saveExp($userId, $exp)
    {
        // TODO: Implement saveExp() method.
    }

    public function deleteExp($id, $userId)
    {
        // TODO: Implement deleteExp() method.
    }

    public function getEducation($userId)
    {
        // TODO: Implement getEducation() method.
    }

    public function getExperiences($userId)
    {
        // TODO: Implement getExperiences() method.
    }

    public function getExperience($id)
    {
        // TODO: Implement getExperience() method.
    }

    public function changeDeliveryType($userId, $type)
    {
        // TODO: Implement changeDeliveryType() method.
    }

    public function searchUsers($conditions, $start, $limit)
    {
        // TODO: Implement searchUsers() method.
    }

    public function countUsers($conditions)
    {
        // TODO: Implement countUsers() method.
    }

    public function saveRecruiterInfo($fields, $user)
    {
        // TODO: Implement saveRecruiterInfo() method.
    }

    public function reDownloadWeixinAvatars()
    {
        // TODO: Implement reDownloadWeixinAvatars() method.
    }

    public function deleteUser($id, $user)
    {
        // TODO: Implement deleteUser() method.
    }

    public function clearResume($userId)
    {
        // TODO: Implement clearResume() method.
    }

    public function addLoginLog($fields)
    {
        // TODO: Implement addLoginLog() method.
    }

    public function clearUserBalance($userId)
    {
        // TODO: Implement clearUserBalance() method.
    }

    public function isInBlacklist($userId)
    {
        // TODO: Implement isInBlacklist() method.
    }
}