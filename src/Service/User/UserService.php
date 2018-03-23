<?php
/**
 * Created by PhpStorm.
 * User: funny
 * Date: 20/03/2018
 * Time: 19:24
 */

namespace App\Service;


interface UserService
{
    const AUTH_STATUS_NONE = 'none';

    const AUTH_STATUS_DRAFT = 'draft';

    const AUTH_STATUS_ACCEPT = 'accept';

    const AUTH_STATUS_DENY = 'deny';

    const AUTH_STATUS_CANCEL = 'cancel';

    public function getUser($id);

    public function getOpenid($id);

    public function getUserByHashid($hashid, $withPrivacy = true);

    public function getUserByUsername($username);

    public function getUserByNickname($nickname);

    public function getUserByWxUnionId($wid);

    public function findUsersByIds($ids);

    public function findUsersByHashids($hashids);

    /**
     * @param $user array weixin user info
     * @param $type string login type (weixin,weixinxcx, weixinmob...)
     *
     * @return mixed
     */
    public function register($user, $type);

    /**
     * @param $id
     * @param $user array weixin user info
     * @param $type string login type (weixin,weixinxcx, weixinmob...)
     *
     * @return mixed
     */
    public function refreshFromWeixin($id, $user, $type);

    public function bindUser($bindId, $bindType, $userId);

    public function switchUserIdentity($userId, $identity);

    public function updateUser($id, $fields, $ignoreEmptyFields = true);

    public function calcResumeProgress($id, $progress);

    public function saveEdu($userId, $edu);

    public function saveExp($userId, $exp);

    public function deleteExp($id, $userId);

    //目前只录入用户的最高教育经历
    public function getEducation($userId);

    //用户的工作经历
    public function getExperiences($userId);

    public function getExperience($id);

    public function changeDeliveryType($userId, $type);

    public function searchUsers($conditions, $start, $limit);

    public function countUsers($conditions);

    public function saveRecruiterInfo($fields, $user);

    public function reDownloadWeixinAvatars();

    public function deleteUser($id, $user);

    public function clearResume($userId);

    public function addLoginLog($fields);

    /**
     * 该接口用于测试时删除用户的余额、流水等信息，请谨慎调用.
     *
     * @param $userId
     */
    public function clearUserBalance($userId);

    /**
     * 判断用户是否在黑名单中
     * @param $userId
     * @return mixed
     */
    public function isInBlacklist($userId);
}